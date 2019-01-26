<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model wdmg\rbac\models\RbacChilds */

$this->title = Yii::t('app/modules/rbac', 'Create Rbac Item Childs');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/modules/rbac', 'Rbac Item Childs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rbac-item-childs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
