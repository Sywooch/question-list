<?php

namespace igribov\questionlist\models;

use Yii;

/**
 * This is the model class for table "questionlist_region".
 *
 * @property integer $id
 * @property string $name
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questionlist_region';
    }

    public function getOffices()
    {
        return $this->hasMany(Office::className(), ['region_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
        ];
    }
}
