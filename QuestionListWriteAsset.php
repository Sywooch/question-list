<?php

namespace app\modules\unicred\questionlist;

use yii\web\AssetBundle;


class QuestionListWriteAsset extends QuestionListBaseAsset
{
    public $js = [
        'js/show_hide_comment.js',
        'js/question_visible.js',
    ];
} 