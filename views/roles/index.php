<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel wdmg\rbac\models\RbacRolesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/modules/rbac', 'Roles and permissions');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="page-header">
    <h1><?= Html::encode($this->title) ?> <small class="text-muted pull-right">[v.<?= $this->context->module->version ?>]</small></h1>
</div>
<p>
    <?= Yii::t('app/modules/rbac', 'Here you can add access roles and permissions, as well as attach access rules to them.') ?>
</p>
<div class="rbac-items-index">

    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'type',
                'format' => 'html',
                'filter' => false,
                'headerOptions' => [
                    'class' => 'text-center'
                ],
                'contentOptions' => [
                    'class' => 'text-center'
                ],
                'value' => function($data) {

                    if ($data->type == $data::TYPE_ROLE)
                        return '<span class="label label-success">'.Yii::t('app/modules/rbac','Role').'</span>';
                    elseif ($data->type == $data::TYPE_PERMISSION)
                        return '<span class="label label-danger">'.Yii::t('app/modules/rbac','Permission').'</span>';
                    else
                        return false;

                },
            ],
            'description:ntext',
            'rule_name',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app/modules/rbac', 'Actions'),
                'contentOptions' => [
                    'class' => 'text-center'
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

    <div>
        <?= Html::a(Yii::t('app/modules/rbac', 'Add new item'), ['roles/create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>

<?php echo $this->render('../_debug'); ?>