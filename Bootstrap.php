<?php

namespace wdmg\rbac;

/**
 * @author          Alexsander Vyshnyvetskyy <alex.vyshnyvetskyy@gmail.com>
 * @copyright       Copyright (c) 2019 W.D.M.Group, Ukraine
 * @license         https://opensource.org/licenses/MIT Massachusetts Institute of Technology (MIT) License
 */

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
