[![Progress](https://img.shields.io/badge/required-Yii2_v2.0.13-blue.svg)](https://packagist.org/packages/yiisoft/yii2) [![Github all releases](https://img.shields.io/github/downloads/wdmg/yii2-rbac/total.svg)](https://GitHub.com/wdmg/yii2-rbac/releases/) [![GitHub version](https://badge.fury.io/gh/wdmg%2Fyii2-rbac.svg)](https://github.com/wdmg/yii2-rbac) ![Progress](https://img.shields.io/badge/progress-in_development-red.svg) [![GitHub license](https://img.shields.io/github/license/wdmg/yii2-rbac.svg)](https://github.com/wdmg/yii2-rbac/blob/master/LICENSE)

# Yii2 RBAC Module
RBAC management module for Yii2

# Requirements 
* PHP 5.6 or higher
* Yii2 v.2.0.13 and newest
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

If you have connected the module not via a composer add Bootstrap section:

`
$config['bootstrap'][] = 'wdmg\rbac\Bootstrap';
`

[Notice] You should configure "authManager" component in config to use database before executing migrations.

# Routing
- `/admin/rbac` - Role and permission
- `/admin/rbac/roles/` - Role and permission, alias of `/admin/rbac/`
- `/admin/rbac/childs/` - Role/permission inheritance from each other
- `/admin/rbac/assignments/` - Data about the assignment of role/permission to users
- `/admin/rbac/rules/` - Store individual rules

# Status and version
* v.1.0.2 - Module in progress development.