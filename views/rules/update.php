<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacRules */

$this->title = Yii::t('app/modules/rbac', 'Update rule: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => $this->context->module->name, 'url' => ['rbac/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/modules/rbac', 'Access rules'), 'url' => ['rules/index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('app/modules/rbac', 'Update');
?>
<div class="rbac-rules-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
