<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacChilds */

$this->title = Yii::t('app/modules/rbac', 'Update Rbac Item Childs: {name}', [
    'name' => $model->parent,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/modules/rbac', 'Rbac Item Childs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->parent, 'url' => ['view', 'parent' => $model->parent, 'child' => $model->child]];
$this->params['breadcrumbs'][] = Yii::t('app/modules/rbac', 'Update');
?>
<div class="rbac-item-childs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
