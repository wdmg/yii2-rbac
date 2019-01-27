<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacRoles */

if ($model->type == $model::TYPE_ROLE)
    $this->title = Yii::t('app/modules/rbac', 'Update role: {name}', [
        'name' => $model->name,
    ]);
else
    $this->title = Yii::t('app/modules/rbac', 'Update permission: {name}', [
        'name' => $model->name,
    ]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app/modules/rbac', 'Rbac Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('app/modules/rbac', 'Update');
?>
<div class="rbac-items-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'rules' => $rules,
        'model' => $model,
    ]) ?>

</div>
