<?php

namespace igribov\questionlist\controllers;

use yii\web\Controller;
use Yii;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index_');
    }

}
