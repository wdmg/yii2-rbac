<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacRolesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title">
            <a data-toggle="collapse" href="#itemSearch">
                <span class="glyphicon glyphicon-search"></span> <?= Yii::t('app/modules/rbac', 'Search items') ?>
            </a>
        </h5>
    </div>
    <div id="itemSearch" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="rbac-items-search">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]); ?>
                <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'type') ?>
                <?= $form->field($model, 'description') ?>
                <?= $form->field($model, 'rule_name') ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app/modules/rbac', 'Search'), ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton(Yii::t('app/modules/rbac', 'Reset'), ['class' => 'btn btn-default']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

