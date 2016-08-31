<?php 

namespace app\components;

class Mvd extends \yii\helpers\VarDumper
{
	public static function dump($var, $nub=10, $hl=true){
		parent::dump($var, $nub, $hl);
	}
}