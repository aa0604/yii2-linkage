<?php
/**
 *
 */
namespace xing\yii2Linkage;

use yii;
use yii\web\AssetBundle;

/**
 * Class Yii2LinkageAsset
 * @package xing\yii2Linkage
 */
class Yii2LinkageAsset extends AssetBundle {

    /**
     * @var
     */
    public $sourcePath;

    /**
     * @var array
     */
    public $js = [
        'yii2.linkage.js',
    ];

    /**
     * @var array
     */
    public $css = [];


    public $publishOptions = [
        'except' => [
            'php/',
            'index.html',
            '.gitignore'
        ]
    ];

    public function init() {
        parent::init();
        if($this->sourcePath == null)
            $this->sourcePath = __DIR__ . DIRECTORY_SEPARATOR . 'assets';
    }

}
