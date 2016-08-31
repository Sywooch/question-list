<?php
namespace app\controllers;

use Yii;


use app\models\Common;

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

class UserLinkedOfficesRegionsController extends Controller {

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

   public function actionDeleteRegion($region_id, $user_id)
   {
        $user = User::findOne($user_id);
        $region = Region::findOne($region_id);

        if(!$user) throw new NotFoundHttpException('Данный пользователь не существует.');

        $user->unlinkRegion($region_id);
        $user->save();
   }

}
