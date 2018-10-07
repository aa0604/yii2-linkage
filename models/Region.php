<?php

namespace xing\yii2Linkage\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property int $regionId 主键
 * @property string $name 名称
 * @property int $parentId 父id
 * @property int $sorting 排序
 */
class Region extends \xing\helper\yii\MyActiveRecord
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

    /**
     * 读取两级城市
     * @param int $reginId 城市id
     * @return string 如广东深圳
     */
    public static function readTwoName(int $reginId)
    {
        $region = self::findOne($reginId);
        $parentRegion = isset($region->parentId) ? self::findOne($region->parentId) : null;
        return ($parentRegion->name ?? '') . ($region->name ?? '');
    }

    /**
     * 根据城市名读取城市信息
     * @param string $name 搜索关键字
     * @param bool $bool 是否左右自动加 % ，否则自己加
     * @return array|null|\yii\db\ActiveRecord|Region
     */
    public static function likeName($name, $bool = true)
    {
        !$bool && $name .= '%';
        return self::find()->where(['like', 'name', $name, $bool])->one();
    }
}
