<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacRoles */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/modules/rbac', 'Rbac Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="page-header">
    <h1><?= Html::encode($this->title) ?> <small class="text-muted pull-right">[v.<?= $this->context->module->version ?>]</small></h1>
</div>
<div class="rbac-items-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'type',
            'description:ntext',
            'rule_name',
            [
                'attribute' => 'data',
                'format' => 'html',
                'value' => function($data) {
                    return '<code>' . Yii::$app->formatter->format(var_export(unserialize($data->data), true), 'ntext') . '</code>';
                }
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::a(Yii::t('app/modules/rbac', '&larr; Back to list'), ['items/index'], ['class' => 'btn btn-default pull-left']) ?>&nbsp;
        <?= Html::a(Yii::t('app/modules/rbac', 'Edit'), ['items/update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/modules/rbac', 'Delete'), ['items/delete', 'id' => $model->name], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => Yii::t('app/modules/rbac', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
</div>
