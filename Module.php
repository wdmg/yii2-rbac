<?php

namespace wdmg\rbac;

/**
 * Yii2 Role-based access control
 *
 * @category        Module
 * @version         1.1.1
 * @author          Alexsander Vyshnyvetskyy <alex.vyshnyvetskyy@gmail.com>
 * @link            https://github.com/wdmg/yii2-rbac
 * @copyright       Copyright (c) 2019 W.D.M.Group, Ukraine
 * @license         https://opensource.org/licenses/MIT Massachusetts Institute of Technology (MIT) License
 *
 */

use Yii;


/**
 * rbac module definition class
 */
class Module extends \yii\base\Module
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
     * @var string the prefix for routing of module
     */
    public $routePrefix = "admin";

    /**
     * @var string, the name of module
     */
    public $name = "RBAC";

    /**
     * @var string, the description of module
     */
    public $description = "Role Based Access Control";

    /**
     * @var string the vendor name of module
     */
    private $vendor = "wdmg";

    /**
     * @var string the module version
     */
    private $version = "1.1.1";

    /**
     * @var integer, priority of initialization
     */
    private $priority = 6;

    /**
     * @var array of strings missing translations
     */
    public $missingTranslation;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // Set controller namespace for console commands
        if (Yii::$app instanceof \yii\console\Application)
            $this->controllerNamespace = 'wdmg\rbac\commands';

        // Set current version of module
        $this->setVersion($this->version);

        // Set default user identity class
        /*if ($this->userClass === null)
            $this->userClass = Yii::$app->getUser()->identityClass;
        */

        // Register auth manager tables
        $this->registerAuthManager();

        // Register translations
        $this->registerTranslations();

        // Normalize route prefix
        $this->routePrefixNormalize();

    }

    /**
     * Return module vendor
     * @var string of current module vendor
     */
    public function getVendor() {
        return $this->vendor;
    }

    /**
     * {@inheritdoc}
     */
    public function afterAction($action, $result)
    {

        // Log to debuf console missing translations
        if (is_array($this->missingTranslation) && YII_ENV == 'dev')
            Yii::warning('Missing translations: ' . var_export($this->missingTranslation, true), 'i18n');

        $result = parent::afterAction($action, $result);
        return $result;

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

    // Registers translations for the module
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['app/modules/rbac'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => '@vendor/wdmg/yii2-rbac/messages',
            'on missingTranslation' => function($event) {

                if (YII_ENV == 'dev')
                    $this->missingTranslation[] = $event->message;

            },
        ];

        // Name and description translation of module
        $this->name = Yii::t('app/modules/rbac', $this->name);
        $this->description = Yii::t('app/modules/rbac', $this->description);
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('app/modules/rbac' . $category, $message, $params, $language);
    }

    /**
     * Normalize route prefix
     * @return string of current route prefix
     */
    public function routePrefixNormalize()
    {
        if(!empty($this->routePrefix)) {
            $this->routePrefix = str_replace('/', '', $this->routePrefix);
            $this->routePrefix = '/'.$this->routePrefix;
            $this->routePrefix = str_replace('//', '/', $this->routePrefix);
        }
        return $this->routePrefix;
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
}
