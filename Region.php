<?php

namespace xing\yii2Linkage;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property int $regionId 主键
 * @property string $name 名称
 * @property int $parentId 父id
 * @property int $sorting 排序
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parentId', 'sorting'], 'integer'],
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'regionId' => '主键',
            'name' => '名称',
            'parentId' => '父id',
            'sorting' => '排序',
        ];
    }
}
