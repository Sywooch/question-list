<?php
/**
 * Created by PhpStorm.
 * User: Илья
 * Date: 12.08.2016
 * Time: 12:13
 */

namespace app\modules\unicred\questionlist\commands;
use yii\console\Controller;
use yii\helpers\Console;


class SendMailController extends Controller
{
    /*
      %COMSPEC% /c %progdir%\modules\php\%phpdriver%\php-win.exe -c %progdir%\modules\php\%phpdriver%\php.ini -q -f %sitedir%\questionlist\yii checklist/send-mail -test
    */
    public function actionIndex($message='TEST')
    {
        $dir = 'D:\server\OpenServer\domains\questionlist\modules\unicred\questionlist\commands';
        $f = fopen(__DIR__.DIRECTORY_SEPARATOR.'test.txt','w');
        fwrite($f,__DIR__.$message);
        fclose($f);
    }
} 