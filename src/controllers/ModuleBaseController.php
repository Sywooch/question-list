<?php

namespace igribov\questionlist\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AnswerListController implements the CRUD actions for AnswerList model.
 */
class ModuleBaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
            'access'=> [
                'class' => 'igribov\questionlist\components\AccessControl',
                'onBeforeAction' => Yii::$app->controller->module->params['onBeforeAction'],
            ],
        ];
        if($moduleConfigBehaviors = Yii::$app->controller->module->params['behaviors'])
            foreach($moduleConfigBehaviors as $behaviodID => $behavior)$behaviors[$behaviodID] = $behavior;
        return $behaviors;
    }

}
