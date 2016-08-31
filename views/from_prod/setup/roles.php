<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use app\models\User;
use johnitvn\ajaxcrud\CrudAsset; 

CrudAsset::register($this);
?>

<script type="text/javascript">
	function changeRole(id) {
		$.ajax({
			method: 'post',
			url: 'ajaxchangeroles',
			dataType: 'json',
			data: 'id='+id+'&role='+$('.changeRole_'+id).val(),
			beforeSend: function () {
				$('.changeRole_'+id).hide()
				$('#load_'+id).fadeIn();
			},
			success: function (data) {
				$('#load_'+id).hide();
				$('.changeRole_'+id).fadeIn()
			},
			error: function () {
				$('#load_'+id).html('<span style="color:red">Произошла ошибка</span>');
			}

		});
	}
</script>

<h3>Настройка ролей пользователей</h3>

<?php $rolesData = (new User())->roles; ?>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'pjax'=>true,
	'columns' => require(__DIR__.'/_columns.php'),
]) ?>
