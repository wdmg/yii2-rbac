<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel wdmg\rbac\models\RbacChildsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/modules/rbac', 'Inheritance permissions and roles');
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

            'parent',
            'child',

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
        <?= Html::a(Yii::t('app/modules/rbac', 'Add new child'), ['childs/create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>
</div>

<?php echo $this->render('../_debug'); ?>