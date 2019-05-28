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
        if (isset($module->routePrefix)) {
            $app->getUrlManager()->enableStrictParsing = true;
            $prefix = $module->routePrefix . '/';
        } else {
            $prefix = '';
        }

        // Add module URL rules
        $app->getUrlManager()->addRules(
            [
                $prefix . '<module:rbac>' => '<module>/rbac/index',
                $prefix . '<module:rbac>/<controller:\w+>' => '<module>/<controller>',
                $prefix . '<module:rbac>/<controller:\w+>/<action:[0-9a-zA-Z_\-]+>' => '<module>/<controller>/<action>',
                $prefix . '<module:rbac>/<controller:\w+>/<action:[0-9a-zA-Z_\-]+>/<id:\d+>' => '<module>/<controller>/<action>',
                [
                    'pattern' => $prefix . '<module:rbac>/',
                    'route' => '<module>/rbac/index',
                    'suffix' => ''
                ], [
                    'pattern' => $prefix . '<module:rbac>/<controller:\w+>/',
                    'route' => '<module>/<controller>',
                    'suffix' => ''
                ], [
                    'pattern' => $prefix . '<module:rbac>/<controller:\w+>/<action:[0-9a-zA-Z_\-]+>/',
                    'route' => '<module>/<controller>/<action>',
                    'suffix' => ''
                ], [
                    'pattern' => $prefix . '<module:rbac>/<controller:\w+>/<action:[0-9a-zA-Z_\-]+>/<id:\d+>/',
                    'route' => '<module>/<controller>/<action>',
                    'suffix' => ''
                ]
            ],
            true
        );
    }
}
