<?php
namespace xing\yii2Linkage;

use xing\yii2Linkage\models\Region;
use yii\base\InvalidParamException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class Likage
 * @property int $likageLevel
 * @package xing\yii2Likage
 */
class Linkage extends Widget
{
    public $model;

    // 使用哪个联动模型
    public $linkageModel = 'xing\yii2Linkage\models\Region';
    // 联动级别，0表示无限级
    public $linkageLevel = 0;

    // 每一级联动对应的名称，如无则默认为 linkageId-x
    public $fieldLevelName = [];

    public $options = ['class'=>'form-control form-control-inline '];

    // 父子关系使用的字段名
    public $relationField = 'parentId';

    // 名称（标题）使用的字符
    public $nameField = 'name';

    // 各个值
    public $fieldsValue = [];
    /**
     * @var string 此属性不用处理
     */
    public $attribute;

    protected $selectClassName = '';

    public $url;

    public function init()
    {
        if (!$this->model) {
            throw new InvalidParamException('model不能为null!');
        }

        //注册资源文件
        $asset = Yii2LinkageAsset::register($this->getView());

    }

    /**
     * 获取联动模型
     * @return Region|mixed
     * @throws \Exception
     */
    protected function getModel()
    {
        if (empty($this->linkageModel)) throw new \Exception('linkageModel 未设置');
        return new $this->linkageModel;
    }

    public function run()
    {

        $url = Url::to("/linkage/default/get?parentField={$this->relationField}&name={$this->nameField}&linkageModel=" . urlencode($this->linkageModel) . "&parentId=");

        $fieldLevelName = json_encode($this->fieldLevelName);
        $fieldsValue = json_encode($this->fieldsValue);
        $this->selectClassName = Html::getInputId($this->model, $this->attribute) . '-select';

        $js = <<<JAVASCRIPT
<script>

var linkageUrl = '$url';

var selectClassName = '$this->selectClassName';
if (typeof fieldLevelName === 'undefined') var fieldLevelName = [];
fieldLevelName[selectClassName] = $fieldLevelName;

if (typeof fieldsValue === 'undefined') var fieldsValue = [];
fieldsValue[selectClassName] = $fieldsValue;

if (typeof linkageMaxLevel === 'undefined') var linkageMaxLevel = [];
linkageMaxLevel[selectClassName] = $this->linkageLevel;


</script>
JAVASCRIPT;
        $js .= '<input type="hidden" value="' . $this->model->formName() .  '[' . $this->attribute . ']" id="input-' .$this->selectClassName . '">';

        $html = '';
        if (!empty($this->fieldsValue)) {
            if (!is_array($this->fieldsValue)) throw new \Exception('fieldsValue 必须为数组');
            foreach ($this->fieldsValue as $index => $val) {
                $html .= $this->dropDownList($index, $val);
            }
        } else {
            $html = $this->dropDownList(0);
        }

        return $html . $js;
    }

    /**
     * 生成下拉框
     * @param $parentId
     * @param $index
     * @return string
     * @throws \Exception
     */
    protected function dropDownList($index, $value = '')
    {
        // 初始化各个选项
        $options = $this->options;
        $options['name'] = $this->fieldLevel[$index] ?? 'linkageId-' . $index;

        $options['class'] .= ' ' . $this->selectClassName;
        $options['data-class-name'] = $this->selectClassName;

        // 赋值
        $options['value'] = $value;

        $parentId = $this->fieldsValue[$index - 1] ?? 0;
        $selectOptions = $this->getModel()::dropDownList($this->nameField, [$this->relationField => $parentId]);

        return Html::activeDropDownList($this->model, $this->attribute, $selectOptions, $options);
    }
}
