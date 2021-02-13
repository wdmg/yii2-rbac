<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel wdmg\rbac\models\RbacChildsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/modules/rbac', 'Inheritance permissions and roles');
$this->params['breadcrumbs'][] = ['label' => $this->context->module->name, 'url' => ['rbac/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="page-header">
    <h1><?= Html::encode($this->title) ?> <small class="text-muted pull-right">[v.<?= $this->context->module->version ?>]</small></h1>
</div>
<p>
    <?= Yii::t('app/modules/rbac', 'Here you can specify which roles and rights are inherited. The nesting level of inherited rights is not limited.') ?>
</p>
<div class="rbac-item-childs-index">

    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'parent',
                'format' => 'raw',
                'value' => function($data) use ($rolesModel) {
                    if ($type = $data->getParentType()) {
                        if ($type == $rolesModel::TYPE_ROLE)
                            return $data->parent . " " . Html::tag('sup', "[" . Yii::t('app/modules/rbac', 'Role') . "]", ['class' => "text-success"]);
                        elseif ($type == $rolesModel::TYPE_PERMISSION)
                            return $data->parent . " " . Html::tag('sup', "[" . Yii::t('app/modules/rbac', 'Permission') . "]", ['class' => "text-danger"]);

                    }

                    return $data->parent;
                }
            ],
            [
                'attribute' => 'child',
                'format' => 'raw',
                'value' => function($data) use ($rolesModel) {
                    if ($type = $data->getChildType()) {
                        if ($type == $rolesModel::TYPE_ROLE)
                            return $data->child . " " . Html::tag('sup', "[" . Yii::t('app/modules/rbac', 'Role') . "]", ['class' => "text-success"]);
                        elseif ($type == $rolesModel::TYPE_PERMISSION)
                            return $data->child . " " . Html::tag('sup', "[" . Yii::t('app/modules/rbac', 'Permission') . "]", ['class' => "text-danger"]);

                    }

                    return $data->child;
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app/modules/rbac', 'Actions'),
                'contentOptions' => [
                    'class' => 'text-center'
                ]
            ],
        ],
        'pager' => [
            'options' => [
                'class' => 'pagination',
            ],
            'maxButtonCount' => 5,
            'activePageCssClass' => 'active',
            'prevPageCssClass' => 'prev',
            'nextPageCssClass' => 'next',
            'firstPageCssClass' => 'first',
            'lastPageCssClass' => 'last',
            'firstPageLabel' => Yii::t('app/modules/rbac', 'First page'),
            'lastPageLabel'  => Yii::t('app/modules/rbac', 'Last page'),
            'prevPageLabel'  => Yii::t('app/modules/rbac', '&larr; Prev page'),
            'nextPageLabel'  => Yii::t('app/modules/rbac', 'Next page &rarr;')
        ],
    ]); ?>
    <?php Pjax::end(); ?>

    <div>
        <?= Html::a(Yii::t('app/modules/rbac', 'Add new child'), ['childs/create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>

<?php echo $this->render('../_debug'); ?>