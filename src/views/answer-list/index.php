<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\date\DatePicker;
use app\yourmodule\AppAsset;

/* @var $this yii\web\View */
/* @var $searchModel igribov\questionlist\models\AnswerListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $statusList array */

$this->title = 'Управление опросами';
$this->params['breadcrumbs'][] = ['label' => 'Система опросов', 'url' => ['/unicred/']];
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
yii\jui\DatePicker::widget(['language'=>'ru']);

$js = '
jQuery(document).ready(function(){
    $( "input[name=\'AnswerListSearch[date_from]\']" ).datepicker({ dateFormat: "yy-mm-dd" ,language:"ru"});
    $( "input[name=\'AnswerListSearch[date_to]\']" ).datepicker({ dateFormat: "yy-mm-dd" });
});
';
$this->registerJs($js);

?>

<div class="answer-list-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            //'pjax' => true,
            'pjax' => false,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus">Назначить</i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Назначить опросный лист отделению','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Обновить']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
               'type' => 'primary',
               'heading' => '<i class="glyphicon glyphicon-list"></i> Конструктор опросов',
               'before'=>'<em>* Потяните за границу колонки, чтобы изменить ее размер.</em>',
               'after'=>BulkButtonWidget::widget([
                           'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Удалить Все',
                               ["bulk-delete"] ,
                               [
                                   "class"=>"btn btn-danger btn-xs",
                                   'role'=>'modal-remote-bulk',
                                   'data-confirm'=>false,
                                   'data-method'=>false,// for overide yii data api
                                   'data-request-method'=>'post',
                                   'data-confirm-title'=>'Вы уверены?',
                                   'data-confirm-message'=>'Вы уверены, что хотите удалить выделенные записи?'
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
