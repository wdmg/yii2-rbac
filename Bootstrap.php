<?php

namespace wdmg\rbac;

use yii\base\BootstrapInterface;
use Yii;


class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        // Get the module instance
        $module = Yii::$app->getModule('rbac');

        // Get URL path prefix if exist
        $prefix = (isset($module->routePrefix) ? $module->routePrefix . '/' : '');

        // Add module URL rules
        /*$app->getUrlManager()->addRules(
            [
                $prefix.'<controller:(default)>/' => 'rbac/<controller>/index',
                $prefix.'rbac/<controller:(default)>/<action:\w+>' => 'rbac/<controller>/<action>',
                $prefix.'<controller:(default)>/<action:\w+>' => 'rbac/<controller>/<action>',
            ],
            false
        );*/
    }
}
