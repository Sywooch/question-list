<?php
namespace app\modules\unicred\questionlist\components;

use app\modules\unicred\questionlist\models\Users;
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
        $profileId = Yii::$app->user->identity->username;
        $userData = Users::findAll(['profile_id'=>$profileId]);
        $roles = array_values(ArrayHelper::map($userData,'id','profile_office_role'));

        //echo'<pre>';var_dump($action->controller->id);echo'</pre>';die;
        if(in_array('admin', $roles)) $access  = true;
        else switch($action->controller->id)
        {
            //Назначать управляющих могут только роли коммерческий директор и админ
            case 'managers':
                $access  = array_intersect(['commercial_director'], $roles);
                break;
            // Отвесать на опросные листы могут только менеджеры и коммерческий директор
            case 'write-test' :
                $access  = array_intersect(['manager','commercial_director'], $roles);
                break;
            //Назначать управляющих и коммерческих директоров и админов могут только роли админ
            case 'users-offices' :
                $access  = in_array('admin', $roles);
                break;
            // Назначать опросы отделениям могут коммерческие директора и админы
            case 'answer-list' :
                $access  = array_intersect(['commercial_director'], $roles);
                break;
            // Редактировать офисы и регионы может только админ
            case 'office' :
            case 'region' :
                $access  = in_array('admin', $roles);
                break;
            default : $access = true;
        }

        return $access ? true : $this->denyAccess();
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
            throw new ForbiddenHttpException('Доступ запрещен.');
        }
        return false;
    }

} 