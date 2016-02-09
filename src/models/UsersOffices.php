<?php

namespace igribov\questionlist\models;

use Yii;

/**
 * This is the model class for table "users_offices".
 *
 * @property integer $id
 * @property string $profile_id
 * @property integer $office_id
 * @property integer $region_id
 * @property string $profile_office_role
 */
class UsersOffices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questionlist_users_offices';
    }

    static public function getRoles()
    {
        return [
            'manager'=>'Управляющий',
            'empl'=>'Сотрудник',
            'admin'=>'Администратор',
            'commercial_director'=>'Коммерческий директор',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id','region_id'], 'required'],
            [['office_id','region_id'], 'integer'],
            [['profile_id', 'profile_office_role'], 'string', 'max' => 50],
        ];
    }

    public function getRole()
    {
        return $this->profile_office_role;
    }

    public function getRoleName()
    {
        return $this->getRoles()[$this->profile_office_role];
    }

    public function getOffice()
    {
        return $this->hasOne(Office::className(), ['id' => 'office_id']);
    }

    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    public function getOfficeName()
    {
        return $this->office->name;
    }

    public function getRegionName()
    {
        return $this->region->name;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile_id' => 'Профайл',
            'office_id' => 'Office ID',
            'Region_id' => 'Region ID',
            'profile_office_role' => 'Роль',
            'officeName' => 'Офис',
            'regionName' => 'Регион',
            'roleName' => 'Роль',
        ];
    }
}
