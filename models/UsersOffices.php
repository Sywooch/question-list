<?php

namespace app\modules\unicred\models;

use Yii;

/**
 * This is the model class for table "users_offices".
 *
 * @property integer $id
 * @property string $profile_id
 * @property integer $office_id
 * @property string $profile_office_role
 */
class UsersOffices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_offices';
    }

    static public function getRoles()
    {
        return [
            'manager'=>'Управляющий',
            'empl'=>'Сотрудник',
            'admin'=>'Администратор',
            'comdir'=>'Коммерческий директор',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'office_id'], 'required'],
            [['office_id'], 'integer'],
            [['profile_id', 'profile_office_role'], 'string', 'max' => 50],
        ];
    }

    public function getRole()
    {
        return $this->profile_office_role;
    }

    public function getOffice()
    {
        return $this->hasOne(Office::className(), ['id' => 'office_id']);
    }

    public function getOfficeName()
    {
        return $this->office->name;
    }

    public function setOfficeName()
    {

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile_id' => 'Profile ID',
            'office_id' => 'Office ID',
            'profile_office_role' => 'Profile Office Role',
            'officeName' => 'Офис'
        ];
    }
}
