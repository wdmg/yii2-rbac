<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacRoles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rbac-items-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([
        $model::TYPE_ROLE => Yii::t('app/modules/rbac','User role'),
        $model::TYPE_PERMISSION => Yii::t('app/modules/rbac','User permission'),
    ]); ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php
    $options = array();
    foreach ($rules as $indx => $object) {
        $options[$object->name] = $object->name;
    }
    echo $form->field($model, 'rule_name')->dropDownList($options);
    ?>

    <?php /*= $form->field($model, 'data')->textInput()*/ ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/modules/rbac', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
