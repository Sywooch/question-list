<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Mail extends Model
{
    public $host = 'smtp.imb.ru';
    public $SMTPAuth = false;
    public $username = '';
    public $password = '';
    public $charSet = "UTF-8";
    public $from = 'news-feed@unicredit.ru';
    public $fromName = 'Новостная лента';

    public $mail;
    public $news;

    function __construct($config = []) {
        
        parent::__construct($config = []);

        $mail = new \PHPMailer;
        $mail->IsSMTP();
        $mail->Host = $this->host;
        $mail->SMTPAuth = $this->SMTPAuth;
        $mail->Username = $this->username;
        $mail->Password = $this->password;
        $mail->CharSet = $this->charSet;
        $mail->SetFrom($this->from, $this->fromName);
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
        $this->mail = $mail;

        return $this;
    }

    public function mailNews($news) {

        $this->news = $news;

        switch ($news->status) { 

            case News::BAD_NEWS:
                $to = 'Author';
                $subject = [
                    'author' => 'Отказано в публикации',
                ];
                break;
            
            case News::MODER_NEWS:
                $subject = [
                    'moderator' => 'У вас появилась новость для модерирования',
                    'admin' => 'Новость на проверке у Модератора',
                ];
                $to = 'Moderator, Admin';
                break;
            
            case News::SMODER_NEWS:
                $subject = '';
                $subject = [
                    'super_moderator' => 'У вас появилась новость для модерирования',
                    'admin' => 'Новость на проверке у Супер-Модератора',
                ];
                $to = 'SuperModerator, Admin';
                break;
            
            case News::ADMIN_NEWS:
                $subject = [
                    'admin' => 'У вас появилась новость для модерирования',
                ];
                $to = 'Admin';
                break;
            
            case News::ACTIVE_NEWS:
                $subject = [
                    'author' => 'Ваша новость опубликована',
                ];
                $to = 'Author';
                break;
            
            default:
                return;
                break;
        }

        $to = explode(', ', $to);

        //var_dump($subject); die;

        foreach ($to as $toRoles) {
            call_user_func(array($this, 'sendMailTo'.$toRoles), $news, $subject);
        }
    }

    public function sendMailToAuthor($news, $subject) {
        $user = \app\models\Users::findOne($news->user_id);

        $body = sprintf(
            '%s <br />
            Ссылка на новость - %s',
            $subject['author'],
            $this->urlToNews($news->id)
        );

        $this->sendMail($user->email, $subject['author'], $body);
    }

    public function sendMailToModerator($news, $subject) {
        $subquery = (new \yii\db\Query)
            ->select('user_id')
            ->from('relation_categories')
            ->where(['category_id'=>$news->category_id]);

        $users = Users::findAll(['id'=>$subquery]);

        foreach ($users as $user) {
                $emails[] = $user->email;
            }

        $body = sprintf(
            '%s <br />
            Ссылка на новость - %s',
            $subject['moderator'],
            $this->urlToNews($news->id)
        );

        $this->sendMail($emails, $subject['moderator'], $body);

    }

    public function sendMailToSuperModerator($news, $subject) {
        $roles = \app\models\AuthAssignment::find()->where(['item_name'=>'super_moderator'])->with('user')->all();
        
        if (!empty($roles)) {
            foreach ($roles as $role) {
                $emails[] = $role->user->email;
            }

            $body = sprintf(
                '%s <br />
                Ссылка на новость - %s',
                $subject['super_moderator'],
                $this->urlToNews($news->id)
            );
            $this->sendMail($emails, $subject['super_moderator'], $body);
        }
    }

    public function sendMailToAdmin($news, $subject) {
        $roles = \app\models\AuthAssignment::find()->where(['item_name'=>'admin'])->with('user')->all();
        
        if (!empty($roles)) {
            foreach ($roles as $role) {
                $emails[] = $role->user->email;
            }

            $body = sprintf(
                '%s <br />
                Ссылка на новость - %s',
                $subject['admin'],
                $this->urlToNews($news->id)
            );

            $this->sendMail($emails, $subject['admin'], $body);
        }
    }

    public function sendMail($to, $subject, $body) {

        if (is_array($to)) {
            foreach ($to as $value) {
                $this->mail->AddAddress($value);
            }
        }
        else
            $this->mail->AddAddress($to);
        
        $this->mail->Subject = $subject;
        $this->mail->MsgHTML($body." <br />".Users::getRespNewsPpl($this->news));
        
        if ($this->mail->send()) {
            $this->mail->clearAddresses();
            return true;
        }
        else
            return false;
    }

    public function urlToNews($id, $action='view') {
        return sprintf(
            '%s%s',
            (new \yii\web\Request)->getHostInfo(),
            \yii\helpers\Url::to(['news/'.$action, 'id'=>$id])
        );
    }
}
