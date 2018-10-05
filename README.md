# yii2-linkage
一个非常简单好用的YII2任意多级联动，带全国数据库和AR模型。可联动如城市，栏目等所有具有上下级关系的数据，兼容任意的数据表结构，只要做一些设置，马上就能支持你的表结构，完全结合ActiveForm进行增加修改


## 安装
```
composer require xing.chen/yii2-linkage

```

##配置
```php
<?php
'modules' => [
    'linkage' => [
        'class' => 'xing\yii2Linkage\Module',
        'regionModel' => 'xing\yii2Linkage\models\Region',
    ]
]
```

## 使用示例
```php
<?= $form->field($model, 'nativeProvinceId', ['labelOptions' => ['label'  =>'籍贯'], 'options' => ['class' => 'form-group  form-inline']])
                        ->widget(\xing\yii2Linkage\Linkage::className(), [
                        'linkageLevel' => 2, // 最多联动多少级，0表示无限
                        'fieldLevelName' => [$model->formName() . '[nativeProvinceId]', $model->formName() . '[nativeCityId]'], // 每一级的表单名，留空则使用linkageId-x作为表单名
                            'fieldsValue' => $model->isNewRecord ? null : [$model->nativeProvinceId, $model->nativeCityId], // 值

//                        'linkageModel' => 'xing\yii2Linkage\models\Region', // 自定使用哪个联动模型
//                        'relationField' => 'parentId' // 自定子数据库中父子关系使用的字段名，默认parentId
//                        'nameField' => 'name',  // 自定义数据库中名称字段名，默认name
//                        'options' => ['class'=>'form-control form-control-inline'], // 自定义表单选项
                    ]);
                    ?>
```
#### 多个字段联动和单个字段联动说明：
如果是多个字段，比如使用provinceId和cityId分别保存两级城市联动的，只需要设置fieldLevelName的值就可以了。需要注意的是，fieldLevelName 和 fieldsValue 的键值是对应的。

如果是单个字段联动，不需要额外设置，正常使用$form->field($model, '字段名')->widget(...)即可