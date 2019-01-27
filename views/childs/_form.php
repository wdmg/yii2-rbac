<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacChilds */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rbac-item-childs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
        $options = array();
        foreach ($roles as $indx => $object) {
            $options[$object->name] = $object->name;
        }
        echo $form->field($model, 'parent')->dropDownList($options);
        echo $form->field($model, 'child')->dropDownList(array_reverse($options));
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/modules/rbac', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
