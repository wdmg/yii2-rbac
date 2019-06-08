<?php

namespace wdmg\rbac;

/**
 * Yii2 Role-based access control
 *
 * @category        Module
 * @version         1.1.4
 * @author          Alexsander Vyshnyvetskyy <alex.vyshnyvetskyy@gmail.com>
 * @link            https://github.com/wdmg/yii2-rbac
 * @copyright       Copyright (c) 2019 W.D.M.Group, Ukraine
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
    private $version = "1.1.4";

    /**
     * @var integer, priority of initialization
     */
    private $priority = 6;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // Set default user identity class
        /*if ($this->userClass === null)
            $this->userClass = Yii::$app->getUser()->identityClass;
        */

    }

    // Registers auth manager for app
    public function registerAuthManager()
    {

        //$authManager = Yii::$app->authManager;
        $authManager = Yii::$app->getAuthManager();
        if ($authManager) {
            $authManager->assignmentTable = $this->assignmentTable;
            $authManager->itemChildTable = $this->itemChildTable;
            $authManager->itemTable = $this->itemTable;
            $authManager->ruleTable = $this->ruleTable;
            $authManager->defaultRoles = ['guest'];
        }
    }

    /**
     * Build dashboard navigation items for NavBar
     * @return array of current module nav items
     */
    public function dashboardNavItems()
    {
        return [
            'label' => $this->name,
            'url' => '#',
            'active' => in_array(\Yii::$app->controller->module->id, ['rbac']),
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
                'cache' => 'cache',
            ]
        ]);

        // Register auth manager tables
        $this->registerAuthManager();
    }
}
