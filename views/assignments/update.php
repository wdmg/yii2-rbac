<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacAssignments */

$this->title = Yii::t('app/modules/rbac', 'Update assignments: {name}', [
    'name' => $model->item_name,
]);
$this->params['breadcrumbs'][] = ['label' => $this->context->module->name, 'url' => ['rbac/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/modules/rbac', 'Access assignments'), 'url' => ['assignments/index']];
$this->params['breadcrumbs'][] = ['label' => $model->item_name, 'url' => ['view', 'item_name' => $model->item_name, 'user_id' => $model->user_id]];
$this->params['breadcrumbs'][] = Yii::t('app/modules/rbac', 'Update');

?>

<div class="rbac-assignments-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'users' => $users,
        'roles' => $roles,
        'model' => $model,
    ]) ?>

</div>
