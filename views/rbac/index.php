<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = $this->context->module->name;
$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?> <small class="text-muted pull-right">[v.<?= $this->context->module->version ?>]</small></h1>
    </div>
    <div class="rbac-index">
        <ul class="list-unstyled">
            <li class="btn-group" style="padding:0 15px 15px 0;">
                <?= Html::a(Yii::t('app/modules/rbac', 'Roles and permissions'), ['roles/index'], ['class' => 'btn btn-default']) ?>
                <?= Html::a(Yii::t('app/modules/rbac', 'Add new item'), ['roles/create'], ['class' => 'btn btn-success']) ?>
            </li>
            <li class="btn-group" style="padding:0 15px 15px 0;">
                <?= Html::a(Yii::t('app/modules/rbac', 'Inheritance rules'), ['childs/index'], ['class' => 'btn btn-default']) ?>
                <?= Html::a(Yii::t('app/modules/rbac', 'Add new child'), ['childs/create'], ['class' => 'btn btn-warning']) ?>
            </li>
            <li class="btn-group" style="padding:0 15px 15px 0;">
                <?= Html::a(Yii::t('app/modules/rbac', 'Access rules'), ['rules/index'], ['class' => 'btn btn-default']) ?>
                <?= Html::a(Yii::t('app/modules/rbac', 'Add new rule'), ['rules/create'], ['class' => 'btn btn-danger']) ?>
            </li>
            <li class="btn-group" style="padding:0 15px 15px 0;">
                <?= Html::a(Yii::t('app/modules/rbac', 'Access assignments'), ['assignments/index'], ['class' => 'btn btn-default']) ?>
                <?= Html::a(Yii::t('app/modules/rbac', 'Add new assignment'), ['assignments/create'], ['class' => 'btn btn-info']) ?>
            </li>
        </ul>
    </div>

<?php echo $this->render('../_debug'); ?>