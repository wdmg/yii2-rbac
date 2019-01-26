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
                $prefix . '<module:rbac>/' => '<module>/items/index',
                $prefix . '<module:rbac>/<controller:(roles|childs|assignments|rules)>/' => '<module>/<controller>',
                $prefix . '<module:rbac>/<controller:(roles|childs|assignments|rules)>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
            true
        );
    }
}
