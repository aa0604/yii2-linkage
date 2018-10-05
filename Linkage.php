<?php
namespace xing\yii2Linkage;

use yii\base\InvalidParamException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class Likage
 * @property int $likageLevel
 * @package xing\yii2Likage
 */
class Linkage extends Widget
{

    // 联动级别，0表示无限级
    public $linkageLevel = 0;

    // 每一级联动对应的名称，如无则默认为 linkageId-x
    public $fieldLevel = [];

    public $options = ['class'=>'form-control form-control-inline','prompt'=>'请选择'];
    /**
     * @var string 此属性不用处理
     */
    public $attribute;


    public $url;

    public function init()
    {
        if (!$this->model) {
            throw new InvalidParamException('model不能为null!');
        }

        //设置实例的名字
        if (!$this->name)
            $this->name = $this->hasModel() ? $this->model->formName() . '_' . $this->attribute : 'ueditor_' . $this->id;


        $fieldName = Html::getInputId($this->model, $this->city['attribute']);
        $cityDefault = Html::renderSelectOptions('city', ['' => $this->options]);

        $joinChar = strripos($this->url, '?') ? '&' : '?';
        $url = $this->url . $joinChar;


        $this->province['options'] = ArrayHelper::merge($this->province['options'], [
            'onchange' => "
                if($(this).val()!=''){
                    $.get('{$url}parent_id='+$(this).val(), function(data) {
                        $('#{$fieldName}').html('{$cityDefault}'+data);
                    })
                }else{
                    $('#{$fieldName}').html('{$cityDefault}');
                }
                $('#{$districtId}').html('{$districtDefault}');
            "
        ]);

    }

    public function run()
    {
        return Html::activeDropDownList($this->model, $this->province['attribute'], $this->province['items'],
            $this->province['options']);
    }

}
