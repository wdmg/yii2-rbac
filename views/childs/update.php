<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacChilds */

$this->title = Yii::t('app/modules/rbac', 'Update inheritance: {name}', [
    'name' => $model->parent,
]);
$this->params['breadcrumbs'][] = ['label' => $this->context->module->name, 'url' => ['rbac/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/modules/rbac', 'Inheritance permissions and roles'), 'url' => ['childs/index']];
$this->params['breadcrumbs'][] = ['label' => $model->parent, 'url' => ['view', 'parent' => $model->parent, 'child' => $model->child]];
$this->params['breadcrumbs'][] = Yii::t('app/modules/rbac', 'Update');
?>
<div class="rbac-item-childs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'roles' => $roles,
        'model' => $model,
    ]) ?>

</div>
