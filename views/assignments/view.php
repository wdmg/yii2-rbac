<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacAssignments */

$this->title = $model->item_name;
$this->params['breadcrumbs'][] = ['label' => $this->context->module->name, 'url' => ['rbac/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/modules/rbac', 'Access assignments'), 'url' => ['assignments/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="page-header">
    <h1><?= Html::encode($this->title) ?> <small class="text-muted pull-right">[v.<?= $this->context->module->version ?>]</small></h1>
</div>
<div class="rbac-assignments-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'user_id',
                'format' => 'html',
                'label' => Yii::t('app/modules/tickets', 'User'),
                'value' => function($model) {
                    if($model->user_id == $model->user['id'])
                        if($model->user['id'] && $model->user['username'])
                            return Html::a($model->user['username'], ['../admin/users/view/?id='.$model->user['id']], [
                                'target' => '_blank',
                                'data-pjax' => 0
                            ]);
                        else
                            return $model->user_id;
                    else
                        return $model->user_id;
                }
            ],
            'item_name',
            'created_at:datetime',
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::a(Yii::t('app/modules/rbac', '&larr; Back to list'), ['assignments/index'], ['class' => 'btn btn-default pull-left']) ?>&nbsp;
        <?= Html::a(Yii::t('app/modules/rbac', 'Edit'), ['assignments/update', 'item_name' => $model->item_name, 'user_id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/modules/rbac', 'Delete'), ['assignments/delete', 'item_name' => $model->item_name, 'user_id' => $model->user_id], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => Yii::t('app/modules/rbac', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
</div>
