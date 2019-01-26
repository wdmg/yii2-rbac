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
        $app->getUrlManager()->addRules(
            [
                $prefix . '<module:rbac>/' => '<module>/rules/index',
                $prefix . '<module:rbac>/<controller:(rules|items|childs|assignments)>/' => '<module>/<controller>',
                $prefix . '<module:rbac>/<controller:(rules|items|childs|assignments)>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
            true
        );
    }
}
