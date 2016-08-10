<?php
namespace app\modules\unicred\questionlist\components;

use app\modules\unicred\questionlist\models\UsersOffices;
use app\modules\unicred\questionlist\models\Office;
use app\modules\unicred\questionlist\models\UsersAccess;
use app\modules\unicred\questionlist\models\AnswerList;
use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;
use yii\helpers\ArrayHelper;

class AccessControl extends ActionFilter
{
    public $onBeforeAction;

    public function beforeAction($action)
    {
        $modelsUsersOffices = null;
        $session = Yii::$app->session;
        $qlUserData = $session->get('qlUserData');

        if($profileId = Yii::$app->user->identity->username)
        {
            $modelsUsersOffices = UsersOffices::find()->where(['profile_id'=>$profileId])->joinWith('office')->joinWith('region')->all();
            Yii::$app->session->set('qlUserData',$modelsUsersOffices);
        }

        $params = \yii\helpers\ArrayHelper::merge(Yii::$app->getRequest()->getQueryParams(),
            Yii::$app->getRequest()->getBodyParams());

        // если пользователем была передана своя управления функция доступом в конфиге
        if( $beforeActionFunction = $this->onBeforeAction ) {
            $res = $beforeActionFunction($action->controller->id,
                $action->id,
                Yii::$app->user->identity,
                $modelsUsersOffices,
                $params);

            if($res) return true;
            else return $this->denyAccess();
        } else {
            // если настройки не было, то поведение стандартное
            $access = true;
            $user_id = Yii::$app->getUser()->identity->username;
            switch($action->controller->id)
            {
                // экшены для управляющего
                case 'write-test' :
                    switch($action->id) {
                        case 'index' :
                            $access =  !!UsersAccess::getUserManagerRoles($user_id);
                            break;
                        case 'send' :
                            // можно отправить ком.директору только лист который заполнялся.
                            $model = AnswerList::findOne($params['id']);
                            $access = $access && ($model->status==='answered');
                        case 'create' :
                        case 'update' :
                            $model = empty($model) ? $model :AnswerList::findOne($params['id']);
                            // при создании и редактировании лист не должен быть в закрытых статусах
                            $access = $access && (!in_array($model->status,['archive','send','done']));
                        case 'view' :
                            // при просмотре важен только доступ к офисам региона
                            $access =  $access && UsersAccess::getUserManagerRoles($user_id);
                            $model = empty($model) ? $model : AnswerList::findOne($params['id']);
                            if(!$access) break;
                            $roles = UsersAccess::getUserManagerRoles($user_id);
                            foreach( ArrayHelper::map($roles,'region_id','region_id') as $region_id )
                            {
                                if($model->office->region->id === $region_id) { $access = true; break; }
                            }
                            break;
                    }
                    break;
                // Данная часть доступна для коммерческих директоров
                case 'statistic' :
                    switch($action->id) {
                        case 'index' :
                            $access =  !!UsersAccess::getUserCommercialDirectorRoles($user_id);
                            break;
                        case 'update' :
                        case 'view' :
                        $access = false;
                            $roles = UsersAccess::getUserCommercialDirectorRoles($user_id);
                            $model = AnswerList::findOne($params['id']);
                            foreach( ArrayHelper::map($roles,'region_id','region_id') as $region_id )
                            {
                                if($model->office->region->id === $region_id) { $access = true; break; }
                            }
                        break;
                    }
                    break;
                // экщены для админа
                case 'users-offices' :
                    $isComDir = UsersAccess::getUserCommercialDirectorRoles($user_id);
                    $isAdmin = UsersAccess::getUserAdminRole($user_id);
                    $access =  $isComDir || $isAdmin;
                    // если не админ и не комм.директор то не проверяем дальше.
                    if(!$access) break;
                    switch($action->id) {
                        case 'create' :
                            if($isComDir) {
                                // Если он хочет создать пользователя
                                if(isset($params['UsersOffices'])) {
                                    //Но он может создать только пользователей с ролью менеджер
                                    $access = $params['UsersOffices']['profile_office_role'] == 'manager';
                                    if(!$access) break;
                                    // и только для офиса своего региона
                                    $office = Office::findOne($params['UsersOffices']['office_id']);
                                    $regions = [];
                                    foreach($qlUserData as $item) {
                                        if($item->profile_office_role == 'commercial_director')
                                            $regions[]= $item->region_id;
                                    }
                                    $access = (in_array($office->region_id,$regions) );
                                }
                            }
                            break;
                        case 'update' :
                            if($isComDir) {
                                $user = UsersOffices::findOne(['profile_id'=>$user_id]);
                                // чьи права он хочет поменять
                                $model = UsersOffices::findOne($params['id']);
                                $office = Office::findOne($model->office_id);
                                $access = ($office->region_id == $user->region_id);
                                // Если он хочет изменить пользователя
                                if(isset($params['UsersOffices'])) {
                                    //Но он может создать только пользователей с ролью менеджер
                                    $access = $params['UsersOffices']['profile_office_role'] == 'manager';
                                    if(!$access) break;
                                    // и только для офиса своего региона
                                    $office = Office::findOne($params['UsersOffices']['office_id']);
                                    $user = UsersOffices::findOne(['profile_id'=>$user_id]);
                                    $access = ($office->region_id == $user->region_id);
                                }
                            }
                            break;
                        case 'delete' :
                        case 'bulk-delete' :
                            // если ком.дир, то он может обновлять данные по пользователям своих регионов
                            if($isComDir && !$isAdmin) {
                                // берем модель, которую пользователь пытается изменить или удалить
                                $model = UsersOffices::findOne($params['id']);
                                $office = Office::findOne($model->office_id);

                                $regions = [];
                                foreach($qlUserData as $item) {
                                    if($item->profile_office_role == 'commercial_director')
                                        $regions[]= $item->region_id;
                                }
                                $access = ($model->profile_office_role == 'manager' &&
                                    in_array($office->region_id,$regions) );
                            }
                            break;
                    }
                    break;
                case 'answer-list' :
                case 'question-list-constructor' :
                case 'office' :
                case 'region' :
                    $access =  !!UsersAccess::getUserAdminRole($user_id);
                    break;
                case 'default' :
                    break;
            }

            return $access ? true : $this->denyAccess();
        }
    }


    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     *
     * @throws ForbiddenHttpException if the user is already logged in.
     */
    protected function denyAccess()
    {
        if ( Yii::$app->user->getIsGuest() )
        {
            Yii::$app->user->loginRequired();
        }
        else
        {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        return false;
    }

} 