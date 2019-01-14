# Yii2 RBAC Module
RBAC management module for Yii2

# Requirements 
* PHP 5.6 or higher
* Yii2 v.2.0.10 and newest
* [Yii2 Users](https://github.com/wdmg/yii2-users) module

# Installation
To install the module, run the following command in the console:

`$ composer require "wdmg/yii2-rbac"`

After configure db connection, run the following command in the console:

`$ php yii rbac/init`

And select the operation you want to perform:
  1) Apply all module migrations
  2) Revert all module migrations

# Migrations
In any case, you can execute the migration and create the initial data, run the following command in the console:

`$ php yii migrate --migrationPath=@vendor/wdmg/yii2-rbac/migrations`

# Configure

To add a module to the project, add the following data in your configuration file:

    'modules' => [
        ...
        'tickets' => [
            'class' => 'wdmg\rbac\Module',
            'routePrefix' => 'admin'
        ],
        ...
    ],

and Bootstrap section:

`
$config['bootstrap'][] = 'wdmg\rbac\Bootstrap';
`

# Routing
`http://example.com/admin/rbac` - Module dashboard

# Status and version
v.1.0.0 - Module in progress development.