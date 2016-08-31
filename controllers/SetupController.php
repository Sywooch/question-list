<?php
namespace app\controllers;

use Yii;
use app\models\News;
use app\models\Files;
use app\models\Common;
use app\models\Categories;
use app\models\User;
use app\models\Office;
use app\models\Region;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;

class SetupController extends Controller {

    public $layout = 'setup';

    public function behaviors() {
        
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        if(!$user) throw new NotFoundHttpException('Данный пользователь не существует.');

        //var_dump($user->authAssignments->item_name);die;
        /* Если пользователь имеет роль Управляющий, то у него есть связанные офисы */
        $officesDataProvider = new ArrayDataProvider([
            'allModels' => $user->offices,
            'pagination' => [
                'PageSize' => 30,
            ]
        ]);

        /* Если пользователь имеет роль Коммерческий директор, то у него есть связанные регионы */
        $regionsDataProvider = new ArrayDataProvider([
            'allModels' => $user->regions,
            'pagination' => [
                'PageSize' => 30,
            ]
        ]);

        return $this->render('update', [
            'officesDataProvider'=>$officesDataProvider, 
            'regionsDataProvider'=>$regionsDataProvider, 
            'user'=>$user
        ]); 
    }

    public function actionChangeRole()
    {
        var_dump($_POST);die;
    }

    public function actionDeputy()
    {
        return $this->render('deputy');
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionRoles() {

        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->orderBy('id DESC'),
            'pagination' => [
                'PageSize' => 150,
            ],
        ]);

        return $this->render('roles', ['dataProvider' => $dataProvider]);
    }

    public function actionAjaxchangeroles() {

        $user = \app\models\AuthAssignment::findOne(['user_id'=>Yii::$app->request->post()['id']]);

        if ($user->user->profile_id == Yii::$app->params['god']) 
            return false;

        $user->item_name = Yii::$app->request->post()['role'];
        if ($user->update()) {
            return true;
        }
    }

}
