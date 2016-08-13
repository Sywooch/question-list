<?php

namespace app\modules\unicred\questionlist;

use yii\web\AssetBundle;


class QuestionListBaseAsset extends AssetBundle
{
    public $baseUrl = '@web';

    public $js = [
        'js/calculate_scores.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->sourcePath = __DIR__.DIRECTORY_SEPARATOR.'assets';
    }
} 