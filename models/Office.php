<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "office".
 *
 * @property integer $id
 * @property integer $region_id
 * @property string $name
 */
class Office extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questionlist_office';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_id', 'name'], 'required'],
            [['region_id'], 'integer'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
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
            'region_id' => 'Регион',
            'regionName' => 'Регион',
            'name' => 'Офис',
        ];
    }
}
