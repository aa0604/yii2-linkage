<?php

/**
 * @var yii\web\View $this
 */
?>
<div class="levelSelect-default-index" xmlns="http://www.w3.org/1999/html">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <?php
                \yii\bootstrap\ActiveForm::begin([
                ]);
                ?>
            </div>

            <?= \yii\helpers\Html::submitButton('submit', ['class'=>"btn btn-default"]); ?>
            <?php
            \yii\bootstrap\ActiveForm::end();
            ?>
        </div>
    </div>
</div>
