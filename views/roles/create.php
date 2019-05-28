<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacRoles */

$this->title = Yii::t('app/modules/rbac', 'Create role or permission');
$this->params['breadcrumbs'][] = ['label' => $this->context->module->name, 'url' => ['rbac/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/modules/rbac', 'Roles and permissions'), 'url' => ['roles/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rbac-items-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'rules' => $rules,
        'model' => $model,
    ]) ?>

</div>
