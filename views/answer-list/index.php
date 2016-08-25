<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use app\modules\unicred\questionlist\CrudAsset as QLCrudAsset;
use app\modules\unicred\questionlist\widgets\BulkButtonWidget;
use hiqdev\yii2\assets\StoreJs\StoreJsAsset;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\unicred\questionlist\models\AnswerListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Answer Lists';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
StoreJsAsset::register($this);
QLCrudAsset::register($this);

?>
<div class="answer-list-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus">Назначить</i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Назначить','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Назначенные чек-листы',
                'before'=>'',
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Удалить все',
                                ["bulk-delete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Удалить назначенный опрос',
                                    'data-confirm-message'=>'Вы уверены, что хотите удалить назначение опроса?'
                                ]).'&nbsp; '.
                                Html::a('<i class="glyphicon glyphicon-book"></i>&nbsp; В архив все',
                                    ["bulk-archive"] ,
                                    [
                                        "class"=>"btn btn-warning btn-xs",
                                        'role'=>'modal-remote-bulk',
                                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                        'data-request-method'=>'post',
                                        'data-confirm-title'=>'Перенести назначенный опрос в архив',
                                        'data-confirm-message'=>'Вы уверены, что хотите перенести назначенный опрос в архив?'
                                    ]),
                        ]).
                        '<div class="clearfix"></div>',
            ],
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>



