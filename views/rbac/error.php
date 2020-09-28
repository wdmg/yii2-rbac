<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = $this->context->module->name;
$this->params['breadcrumbs'] = null;
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = Yii::t('app/modules/rbac', 'Error {code}', ['code' => $exception->statusCode]);

?>
<div class="page-header">
    <?php
        if ($exception->statusCode == 404)
            $header = 'Error {code}. Not found';
        elseif ($exception->statusCode == 403)
            $header = 'Error {code}. Forbidden';
        else
            $header = 'Error';
    ?>
    <h1 class="text-danger"><?= Yii::t('app/modules/rbac', $header, [
        'code' => $exception->statusCode
    ]) ?> <small class="text-muted pull-right">[v.<?= $this->context->module->version ?>]</small></h1>
</div>
<div class="rbac-error">
    <blockquote>
        <?= Yii::t('app/modules/rbac', $exception->getMessage()); ?>
    </blockquote>
</div>