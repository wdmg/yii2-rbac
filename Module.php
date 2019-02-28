<?php

namespace wdmg\rbac;

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
     * @var string the vendor name of module
     */
    private $vendor = "wdmg";

    /**
     * @var string the module version
     */
    private $version = "1.0.3";

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
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('app/modules/rbac' . $category, $message, $params, $language);
    }
}
