<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacAssignments */

$this->title = Yii::t('app/modules/rbac', 'Create Rbac Assignments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/modules/rbac', 'Rbac Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rbac-assignments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
