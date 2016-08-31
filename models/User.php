<?php

namespace app\models;

use Yii;
use app\components\MyLdap;
use yii\helpers\Html;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{ 
    CONST ADMIN   = 'admin';
    CONST COMDIR  = 'commercial_director';
    CONST MANAGER = 'manager';
    CONST GUEST   = 'guest';

    public $roles = [
        'admin'=>'Админ',
		'manager'=>'Управляющий',
		'commercial_director'=>'Коммерческий директор',
        'guest' => 'Гость'
    ];

    public function behaviors()
    {

        return [
            [
                'class' => \voskobovich\behaviors\ManyToManyBehavior::className(),
                'relations' => [
                    'regions_ids' => 'regions',
                    'offices_ids' => 'offices',
                ],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['regions_ids', 'offices_ids'], 'each', 'rule' => ['integer']]
        ];
    }

    protected $isAdmin;

    public static function tableName() {
        return 'questionlist_users';
    }

    public static function findIdentity($id) {   
        return static::findOne($id);
    }

    public static function findByUsername($login) {
        return self::findOne(['profile_id' => $login]);
    }

    public function getId(){
        return $this->id;
    }

    public function validatePassword($password){
        return $this->password === $password;
    }

    public function attributeLabels(){
        return [
            'id' => 'ID',
            'profile_id' => 'Логин',
            'fullname' => 'Имя',
            'email' => 'Email',
            'reg_date' => 'Дата регистрации',
            'isAdmin' => $this->roles[self::ADMIN],
        ];
    }

    public static function newUser($login)
    { 
        $newuser = new self;
        $newuser->profile_id = $login;
        $newuser->save();

        $auth = Yii::$app->authManager;
        $auth->assign($auth->getRole('guest'), $newuser->getId());
    }

    public static function checkPassword($user, $login, $password) {  

        if (is_null($user)) {
            $user = new self;
            $user->profile_id = $login;
        }
        
        $ldap = new MyLdap($login, $password);

        if ($ldap->isUser()) {
            $userData = $ldap->searchUser();
            $user->fullname = $userData['name_ru'];
            $user->email = $userData['email'];
            $new = $user->isNewRecord;
            if ($user->save()) {
                if ($new) {
                    $auth = Yii::$app->authManager;
                    $auth->assign($auth->getRole('guest'), $user->getId());
                }
                return true;
            }
        }
        return false;
    }

    /* 
     * Возвращает по роли пользователя доступные офисы 
     * Возможна ситуация , когда пользователь в офисе_1 региона_1  - Управляющий, 
     * а в регионе_2 он Коммерческий директор (и имеет доступ ко всем офисам региона) 
    */
    public function getAccessableOfficesWhereUserIs($role)
    {
        switch($role)
        {
            case self::MANAGER:
                return $this->offices; 
            break;
            case self::COMDIR:
                /* Коммерческий директор имеет доступ к офисам своего региона */
                $offices = [];
                $regions = Region::find(['user_id'=>'id'])->innerJoin('questionlist_users_to_regions utr',
                            'utr.region_id='.Region::tableName().'.id',
                            ['utr.user_id'=>$this->id]
                        )->with('offices')->all();

                if(!$regions) return;

                foreach ($regions as $region) {
                    $offices = array_merge($offices, $region->offices);
                }
                return $offices;
            break;
            case self::ADMIN :
                /* Админ имеет доступ к всем офисам */
                if(!$this->isAdmin) return;
                return Office::find()->all();
            break;
        }
    }

    public function getIsAdmin()
    {
        return in_array(self::ADMIN, array_keys($this->userRoles));
    }

    public function getOffices()
    {
        return $this->hasMany(Office::className(), ['id'=>'office_id'])
            ->viaTable('questionlist_users_to_offices', ['user_id'=>'id']);        
    }

    public function getUserRoles()
    {
        return Yii::$app->authManager->getRolesByUser($this->id);
    }

    public function getRegions()
    {
        return $this->hasMany(Region::className(), ['id'=>'region_id'])
            ->viaTable('questionlist_users_to_regions', ['user_id'=>'id']);        
    }

    public function getAuthAssignments()
    {
       return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }

    public function getAuthAssignmentsItemName()
    {
        return $this->authAssignments->item_name;
    }

    /* Отвязывает регион от пользователя , если регион существует */
    public function unlinkRegion($region_id)
    {
        $userRegions = $this->regions_ids;
        if( ($key = array_search($region_id, $userRegions))!==false ) {
            unset($userRegions[$key]);
            $this->regions_ids = $userRegions;
        } 
    }

    public function unsetRole($role)
    {
        if(!in_array($role, [self::COMDIR,self::MANAGER])) return;
        $userRole = Yii::$app->authManager->getRole($role);
        Yii::$app->authManager->remove($userRole, $this->id);
    }

    public function genButton($button) {
        if ($button == 'update') {
            return Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['setup/update', 'id'=>$this->id]);
        }
        elseif (Yii::$app->user->can('setup', ['news'=>$this]) && $button == 'view') {
            return Html::a('<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>', ['setup/userview', 'id'=>$this->id]);
        }
        
        return '';
    }

    public function getAuthKey(){}
    public function validateAuthKey($authKey){}
    public static function findIdentityByAccessToken($token, $type = null){}
}
