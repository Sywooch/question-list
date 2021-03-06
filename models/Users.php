<?php

namespace app\modules\unicred\questionlist\models;

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
class Users extends \yii\db\ActiveRecord
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
            [['profile_id','profile_office_role'], 'required'],
            [['profile_id', 'profile_office_role'], 'string', 'max' => 50],
            ['office_id', 'required', 'when' => function($model){
                    return $model->profile_office_role == 'manager';
                },
            ],
            ['region_id', 'required', 'when' => function($model){
                return $model->profile_office_role == 'commercial_director';
            },
            ],
            ['region_id', 'default', 'value'=> function($model){
                return Office::findOne($model->office_id)->region_id;
            }],
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
            'office_id' => 'Офис',
            'region_id' => 'Регион',
            'profile_office_role' => 'Роль',
            'officeName' => 'Офис',
            'regionName' => 'Регион',
            'roleName' => 'Роль',
        ];
    }
}
