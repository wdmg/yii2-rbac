<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacRules */

$this->title = Yii::t('app/modules/rbac', 'Create rule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/modules/rbac', 'Access rules'), 'url' => ['rules/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rbac-rules-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
