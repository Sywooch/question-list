<?php
namespace app\modules\unicred\questionlist\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class BulkButtonWidget extends Widget{

	public $buttons;
	
	public function init(){
		parent::init();
		
	}
	
	public function run(){
		$content = '<div class="pull-left">'.
                   '<span class="glyphicon glyphicon-arrow-right"></span>&nbsp;&nbsp;С отмеченными&nbsp;&nbsp;'.
                   $this->buttons.
                   '</div>';
		return $content;
	}
}
?>
