<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacAssignmentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title">
            <a data-toggle="collapse" href="#assignmentsSearch">
                <span class="glyphicon glyphicon-search"></span> <?= Yii::t('app/modules/rbac', 'Assignments search') ?>
            </a>
        </h5>
    </div>
    <div id="assignmentsSearch" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="rbac-assignments-search">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]); ?>
                <?= $form->field($model, 'item_name') ?>
                <?= $form->field($model, 'user_id') ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app/modules/rbac', 'Search'), ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton(Yii::t('app/modules/rbac', 'Reset'), ['class' => 'btn btn-default']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
