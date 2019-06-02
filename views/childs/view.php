<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacChilds */

$this->title = $model->parent;
$this->title = Yii::t('app/modules/rbac', 'Inheritance child: {name}', ['name' => $model->parent]);
$this->params['breadcrumbs'][] = ['label' => $this->context->module->name, 'url' => ['rbac/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/modules/rbac', 'Inheritance permissions and roles'), 'url' => ['childs/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="page-header">
    <h1><?= Html::encode($this->title) ?> <small class="text-muted pull-right">[v.<?= $this->context->module->version ?>]</small></h1>
</div>
<div class="rbac-item-childs-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'parent',
            'child',
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::a(Yii::t('app/modules/rbac', '&larr; Back to list'), ['childs/index'], ['class' => 'btn btn-default pull-left']) ?>&nbsp;
        <?= Html::a(Yii::t('app/modules/rbac', 'Edit'), ['childs/update', 'parent' => $model->parent, 'child' => $model->child], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/modules/rbac', 'Delete'), ['childs/delete', 'parent' => $model->parent, 'child' => $model->child], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => Yii::t('app/modules/rbac', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
</div>
