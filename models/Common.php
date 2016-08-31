<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use app\models\RelationCategories;

class Common extends Model {

    public static function isLocalServer() {

        return true;
        
        if ($_SERVER['HTTP_HOST'] == 'unicnews2') {
            return true;
        }
        else
            return false;
    }

    public static function getBaseUrlForLeftMenu($icon = 'glyphicon glyphicon-home')
    {
    	return sprintf('<a href="%s"><span class="%s"></span> Главная</a>', 
    		Url::base(),
    		$icon
    	);
    }

    public static function dump($i) {
        if (Yii::$app->user->id == 14) {
            \app\components\Mvd::dump($i); die;
        }
    }

    public static function isAdmin(){
        return self::getRole() == 'admin';
    }

    public static function getStatus($model) {
        $user_id = Yii::$app->user->id;
        $role = self::getRole();
        $nList = [];
        $status = $model->status;
        $sList = $model->status_list;

        if ($model->isNewRecord) {
            foreach ($sList[News::TEMP_NEWS]['list'][self::isAdmin()?'admin':'other'] as $key) {
                $nList[$key] = $sList[$key]['title'];
            }
        }
        else
            foreach ($sList[$status]['list'][self::isAdmin()?'admin':'other'] as $key) {
                $nList[$key] = $sList[$key]['title'];
            }

        return $nList;
    }

    public static function showMenu($checkRoles) {

        if (!Yii::$app->user->isGuest) {
            $role = User::findOne(Yii::$app->user->id)->authAssignments->item_name;

            $checkRoles = explode(',', $checkRoles);

            foreach ($checkRoles as $key => $value) {
                $checkRoles[$key] = trim($value);
            }

            if (array_search($role, $checkRoles) !== false) {
                return true;
            }
            return false;
        }

        return false;
    }

    public static function getRole() {

        return User::findOne(Yii::$app->user->id)->authAssignments->item_name;
    }

    public static function getBeautifyStatus($status){

        switch ($status) {
            case News::TEMP_NEWS:
                return ['default','Черновик'];
                break;
            case News::MODER_NEWS:
                return ['primary','На утверждении модератора'];
                break;
            case News::SMODER_NEWS:
                return ['warning','На утверждении супер-модератора'];
                break;
            case News::ADMIN_NEWS:
                return ['info','На утверждении администратора'];
                break;
            case News::ACTIVE_NEWS:
                return ['success','Опубликовано'];
                break;
            case News::BAD_NEWS:
                return ['danger','Отказано в публикации'];
                break;
            default:
                return ['danger','Ошибка статуса'];
                break;
        }
    }

    public static function getActuallyStatus($model) {
        
        $category = $model->category_id;
        $role = self::getRole();
        $user_id = Yii::$app->user->id;
        
        $haveModers = RelationCategories::find()->joinWith(['role'])->where([
            'category_id'=>$category, 
            'auth_assignment.item_name'=>User::MODER
        ])->all();

        $moderHaveRCategory = RelationCategories::find()->joinWith(['role'])->where([
            'relation_categories.user_id'=>$user_id,
            'category_id'=>$category, 
            'auth_assignment.item_name'=>User::MODER
        ])->one();

        $haveSModers = RelationCategories::find()->joinWith(['role'])->where([
            'category_id'=>$category, 
            'auth_assignment.item_name'=>User::SMODER
        ])->all();

        $smoderHaveRCategory = RelationCategories::find()->joinWith(['role'])->where([
            'relation_categories.user_id'=>$user_id,
            'category_id'=>$category, 
            'auth_assignment.item_name'=>User::SMODER
        ])->one();

        if ($model->status == News::MODER_NEWS && $role != User::ADMIN) {
            if ($model->isNewRecord || 
                $model->oldAttributes['status'] == News::TEMP_NEWS || 
                $model->oldAttributes['status'] == News::BAD_NEWS) {
                
                if (empty($haveModers)) {
                    $model->status = News::SMODER_NEWS;
                }
                else {
                    if ($role == User::MODER) {
                        if (!is_null($moderHaveRCategory)) {
                            $model->status = News::SMODER_NEWS;
                        }
                    }
                }
            }
        }

        if ($model->status == News::SMODER_NEWS && $role != User::ADMIN) {
            if (empty($haveSModers)) {
                $model->status = News::ADMIN_NEWS;
            }
            else {
                if ($role == User::SMODER) {
                    if (!is_null($smoderHaveRCategory)) {
                        $model->status = News::ADMIN_NEWS;
                    }
                }
            }
        }
    }

    public static function sendToJoomla($news) {
        
        $old = new \app\models\Joomla_old;
        $new = new \app\models\Joomla_new;
        $old->loadData($news);
        $new->loadData($news);   
    }

    public static function genText($news) {

        $files = Files::find()->where(['news_id'=>$news->id])->all();

        $files_in_text = '';
        if (!empty($files)) {
            foreach ($files as $file) {
                $files_in_text .= sprintf(
                    "<a style='color:blue; font-weight:bold;' target='_blank' href='http://%s/%s/%s/%s/%s/%s.%s'>%s.%s</a><br />",
                    $_SERVER['SERVER_NAME'],
                    Files::SUB_DIR,
                    Files::UPLOAD_DIR,
                    Files::UPLOAD_FILE_DIR,
                    $file->dir,
                    $file->file_name,
                    $file->ext,
                    $file->origin_file_name,
                    $file->ext
                );
            }
        }

        if (!empty($news->start_date)) {
            
            $start_date = Yii::$app->formatter->asDate($news->start_date, 'php:d.m.Y');
            $date_in_text = sprintf(
                '<u>Дата ввода в действие</u>: %s <br />',
                $start_date
            );

            if ($news->type == \app\models\News::NT_CAMPAIGN) {
                $stop_date = Yii::$app->formatter->asDate($news->stop_date, 'php:d.m.Y');
                $date_in_text = sprintf(
                    '<u>Срок действия акции</u>: %s - %s <br />',
                    $start_date,
                    $stop_date
                );
            }
        }
        else
            $date_in_text='';


        // ----------------------------

        // Документ, регламентирующий изменения --------------------
        if (!empty($news->document)) {
            $document_in_text = sprintf(
                '<u>Документ, регламентирующий изменения</u>: %s <br />',
                $news->document
            );
        }
        else
            $document_in_text = '';

        if (!empty($news->product)) {
            $product_in_text = sprintf(
                '<u>Продукт</u>: %s <br />',
                $news->product
            );
        }
        else 
            $product_in_text = '';
        

        $category_title_in_text = sprintf(
            '<u>Сегмент</u>: %s <br />',
            Categories::findOne($news->category_id)->title
        );


        $textGen = sprintf(
            "<div style='font-size:10pt;font-family:Arial,serif;'><br />
                %s
                %s
                %s
                %s
                <br />%s
                %s
            </div>",
            $date_in_text,
            $category_title_in_text,
            $document_in_text,
            $product_in_text,
            $news->text,
            $files_in_text
        );

        return $textGen;
    }

}
