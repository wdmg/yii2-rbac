<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacAssignments */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="rbac-assignments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $options = array();
    foreach ($users as $indx => $object) {
        $options[$object->id] = $object->username . ' [id: ' . $object->id . ']';
    }
    echo $form->field($model, 'user_id')->dropDownList($options);
    ?>

    <?php
    $options = array();
    foreach ($roles as $indx => $object) {
        $options[$object->name] = $object->name;
    }
    echo $form->field($model, 'item_name')->dropDownList($options);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app/modules/rbac', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
