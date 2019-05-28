<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacAssignments */

$this->title = Yii::t('app/modules/rbac', 'Create assignments');
$this->params['breadcrumbs'][] = ['label' => $this->context->module->name, 'url' => ['rbac/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/modules/rbac', 'Access assignments'), 'url' => ['assignments/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rbac-assignments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'users' => $users,
        'roles' => $roles,
        'model' => $model,
    ]) ?>

</div>
