<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\unicred\questionlist\models\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $list_id int */

$this->title = 'Вопросы опросного листа ID#'.$list_id;
$this->params['breadcrumbs'][] = [
            'label' => 'Опросные листы',
            'url' => ['question-list/index']
            ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <p>
        <?= Html::a('Добавить вопрос', ['create','list_id'=>$list_id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'questionTypeName',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'quest_text',
                'value' => function($model){
                  return mb_substr($model->quest_text,0,20).'...';
                }
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'answerVariantsInline',
                'value' => function($model){
                  if($model->type == 'checkbox') return 'Да/Нет';
                  if($model->type == 'text') return 'Ручной ввод';
                  return mb_strlen($model->answerVariantsInline) > 50 ?
                    mb_substr($model->answerVariantsInline,0,100).'...' : $model->answerVariantsInline;
                }
            ],
            'ordering',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'update' => function($url, $model) use ($list_id){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            Url::toRoute(['update','id'=>$model->id, 'list_id'=>$list_id ]));
                    },
                    'view' => function($url, $model) use ($list_id){
                                            return Html::a(
                                                '<span class="glyphicon glyphicon-eye-open"></span>',
                                                Url::toRoute(['view','id'=>$model->id, 'list_id'=>$list_id ]));
                                        },
                    'delete' => function($url, $model) use ($list_id){
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            Url::toRoute(['delete','id'=>$model->id,'list_id'=>$list_id ]),
                            [
                                'data-confirm'=>'Вы уверены, что хотите удалить поле?',
                                'data-method' => 'post',
                            ]);
                    }
                ],
            ],
        ],
    ]); ?>
</div>

<?php $this->registerJs('
  $(function(){
      console.log($("table").length);
      $("table").resizableColumns();
    });
'); ?>
