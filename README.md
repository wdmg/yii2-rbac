[![Yii2](https://img.shields.io/badge/required-Yii2_v2.0.33-blue.svg)](https://packagist.org/packages/yiisoft/yii2)
[![Downloads](https://img.shields.io/packagist/dt/wdmg/yii2-rbac.svg)](https://packagist.org/packages/wdmg/yii2-rbac)
[![Packagist Version](https://img.shields.io/packagist/v/wdmg/yii2-rbac.svg)](https://packagist.org/packages/wdmg/yii2-rbac)
![Progress](https://img.shields.io/badge/progress-in_development-red.svg)
[![GitHub license](https://img.shields.io/github/license/wdmg/yii2-rbac.svg)](https://github.com/wdmg/yii2-rbac/blob/master/LICENSE)

# Yii2 RBAC Module
RBAC management module for Yii2

# Requirements 
* PHP 5.6 or higher
* Yii2 v.2.0.33 and newest
* [Yii2 Users](https://github.com/wdmg/yii2-users) module

# Installation
To install the module, run the following command in the console:

`$ composer require "wdmg/yii2-rbac:dev-master"`

After configure db connection, run the following command in the console:

`$ php yii rbac/init`

And select the operation you want to perform:
  1) Apply all module migrations
  2) Add base roles and rules for users
  3) Revert all module migrations

# Migrations
In any case, you can execute the migration and create the initial data, run the following command in the console:

`$ php yii migrate --migrationPath=@vendor/wdmg/yii2-rbac/migrations`

# Configure

To add a module to the project, add the following data in your configuration file:

    'components' => [
        ...
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            ...
        ],
        ...
    ],
    'modules' => [
        ...
        'rbac' => [
            'class' => 'wdmg\rbac\Module',
            'routePrefix' => 'admin'
        ],
        ...
    ],

[Notice] You should configure "authManager" component in config to use database before executing migrations.

# Routing
Use the `Module::dashboardNavItems()` method of the module to generate a navigation items list for NavBar, like this:

    <?php
        echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
            'label' => 'Modules',
            'items' => [
                Yii::$app->getModule('rbac')->dashboardNavItems(),
                ...
            ]
        ]);
    ?>

# Status and version [in progress development]
* v.1.2.0 - Update copyrights, fix nav menu
* v.1.1.10 - RBAC implementation for related modules
* v.1.1.9 - Added pagination, up to date dependencies
* v.1.1.8 - Fixed deprecated class declaration
* v.1.1.7 - Fix Invalid datetime format
* v.1.1.6 - Added extra options to composer.json and navbar menu icon