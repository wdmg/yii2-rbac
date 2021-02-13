<?php

namespace wdmg\rbac;

/**
 * Yii2 Role-based access control
 *
 * @category        Module
 * @version         1.1.9
 * @author          Alexsander Vyshnyvetskyy <alex.vyshnyvetskyy@gmail.com>
 * @link            https://github.com/wdmg/yii2-rbac
 * @copyright       Copyright (c) 2019 - 2021 W.D.M.Group, Ukraine
 * @license         https://opensource.org/licenses/MIT Massachusetts Institute of Technology (MIT) License
 *
 */

use Yii;
use wdmg\base\BaseModule;


/**
 * RBAC module definition class
 */
class Module extends BaseModule
{

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'wdmg\rbac\controllers';

    /**
     * @var string the default or custom user identity class
     */
    public $userClass;

    /**
     * @var strings the default tables names
     */
    public $assignmentTable = '{{%rbac_assignments}}';
    public $itemChildTable = '{{%rbac_childs}}';
    public $itemTable = '{{%rbac_roles}}';
    public $ruleTable = '{{%rbac_rules}}';

    /**
     * {@inheritdoc}
     */
    public $defaultRoute = "rbac/index";

    /**
     * @var string, the name of module
     */
    public $name = "RBAC";

    /**
     * @var string, the description of module
     */
    public $description = "Role Based Access Control";

    /**
     * @var string the module version
     */
    private $version = "1.1.9";

    /**
     * @var integer, priority of initialization
     */
    private $priority = 2;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // Set version of current module
        $this->setVersion($this->version);

        // Set priority of current module
        $this->setPriority($this->priority);

    }

    // Registers auth manager for app
    public function registerAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if ($authManager) {
            $authManager->assignmentTable = $this->assignmentTable;
            $authManager->itemChildTable = $this->itemChildTable;
            $authManager->itemTable = $this->itemTable;
            $authManager->ruleTable = $this->ruleTable;
            $authManager->defaultRoles = ['user'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dashboardNavItems($options = false)
    {
        return [
            'label' => $this->name,
            'url' => '#',
            'icon' => 'fa fa-fw fa-lock',
            'active' => in_array(\Yii::$app->controller->module->id, [$this->id]),
            'items' => [
                [
                    'label' => Yii::t('app/modules/rbac', 'Roles and permissions'),
                    'url' => [$this->routePrefix . '/rbac/roles/'],
                    'active' => (in_array(\Yii::$app->controller->module->id, ['rbac']) &&  Yii::$app->controller->id == 'roles'),
                ],
                [
                    'label' => Yii::t('app/modules/rbac', 'Inheritance rules'),
                    'url' => [$this->routePrefix . '/rbac/childs/'],
                    'active' => (in_array(\Yii::$app->controller->module->id, ['rbac']) &&  Yii::$app->controller->id == 'childs'),
                ],
                [
                    'label' => Yii::t('app/modules/rbac', 'Access rules'),
                    'url' => [$this->routePrefix . '/rbac/rules/'],
                    'active' => (in_array(\Yii::$app->controller->module->id, ['rbac']) &&  Yii::$app->controller->id == 'rules'),
                ],
                [
                    'label' => Yii::t('app/modules/rbac', 'Access assignments'),
                    'url' => [$this->routePrefix . '/rbac/assignments/'],
                    'active' => (in_array(\Yii::$app->controller->module->id, ['rbac']) &&  Yii::$app->controller->id == 'assignments'),
                ],
            ]
        ];
    }


    public function bootstrap($app)
    {
        parent::bootstrap($app);

        // Configure authManager component
        $app->setComponents([
            'authManager' => [
                'class' => 'yii\rbac\DbManager',
                'cache' => 'cache'
            ]
        ]);

        // Set error handler
        if (!($app instanceof \yii\console\Application) && $this->isBackend()) {
            if ($errorHandler = $app->getErrorHandler()) {
                $errorHandler->errorAction = $this->routePrefix . '/rbac/rbac/error';
            } else {
                $app->setComponents([
                    'errorHandler' => [
                        'errorAction' => $this->routePrefix . '/rbac/rbac/error'
                    ]
                ]);
            }
        }

        // Register auth manager tables
        $this->registerAuthManager();

        // Check basic access for backend
        if (!($app instanceof \yii\console\Application) && $this->isBackend()) {
            \yii\base\Event::on(\yii\web\Controller::class, \yii\web\Controller::EVENT_BEFORE_ACTION, function ($event) use ($app) {

                // Build current route
                $route = '';
                if ($modules = $event->action->controller->modules) {
                    foreach ($modules as $module) {
                        // Exclude itself and app as module
                        if (!($module->id == $event->action->controller->module->id) && !($module->id == $app->id)) {
                            $route .= (empty($route)) ? $module->id : '/' . $module->id;
                        }
                    }
                }

                if ($module = $event->action->controller->module->id);
                    $route .= (empty($module)) ? $module : '/' . $module;

                if ($controller = $event->action->controller->id);
                    $route .= (empty($controller)) ? $controller : '/' . $controller;

                if ($action = $event->action->id);
                    $route .= (empty($action)) ? $action : '/' . $action;

                // Get all available routes from RBAC
                $routes = [];
                if ($permissions = $app->authManager->permissions) {
                    foreach ($permissions as $permission) {
                        if ($permission->type == \wdmg\rbac\models\RbacRoles::TYPE_ROUTE)
                            $routes[] = $permission->name;
                    }
                }

                // Check if exist and check access
                if (!empty($route) && !empty($routes)) {
                    if (!$app->user->can($route) && in_array($route, $routes, true)) {
                        throw new \yii\web\ForbiddenHttpException('Access denied. You are not allowed to perform this action.');
                    }
                }

            });
        }
    }
}
