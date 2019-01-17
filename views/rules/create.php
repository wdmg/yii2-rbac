<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacRules */

$this->title = Yii::t('app/modules/rbac', 'Create Rbac Rules');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/modules/rbac', 'Rbac Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rbac-rules-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
