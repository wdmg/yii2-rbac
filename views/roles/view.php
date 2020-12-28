<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacRoles */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $this->context->module->name, 'url' => ['rbac/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/modules/rbac', 'Roles and permissions'), 'url' => ['index']];
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
            [
                'attribute' => 'type',
                'format' => 'html',
                'value' => function($data) {

                    if ($data->type == $data::TYPE_ROLE)
                        return '<span class="label label-success">'.Yii::t('app/modules/rbac','User role').'</span>';
                    elseif ($data->type == $data::TYPE_PERMISSION)
                        return '<span class="label label-danger">'.Yii::t('app/modules/rbac','User permission').'</span>';
                    else
                        return false;

                },
            ],
            [
                'attribute' => 'description',
                'format' => 'text',
                'value' => function($data) {
                    return Yii::t('app/modules/rbac', $data->description);
                }
            ],
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
        <?= Html::a(Yii::t('app/modules/rbac', '&larr; Back to list'), ['roles/index'], ['class' => 'btn btn-default pull-left']) ?>&nbsp;
        <?= Html::a(Yii::t('app/modules/rbac', 'Edit'), ['roles/update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app/modules/rbac', 'Delete'), ['roles/delete', 'id' => $model->name], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => Yii::t('app/modules/rbac', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </div>
</div>
