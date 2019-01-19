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
    public $itemTable = '{{%rbac_items}}';
    public $ruleTable = '{{%rbac_rules}}';

    /**
     * @var string the prefix for routing of module
     */
    public $routePrefix = "admin";

    /**
     * @var string the vendor name of module
     */
    public $vendor = "wdmg";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // Set controller namespace for console commands
        if (Yii::$app instanceof \yii\console\Application)
            $this->controllerNamespace = 'wdmg\rbac\commands';

        // Set default user identity class
        if ($this->userClass === null)
            $this->userClass = Yii::$app->getUser()->identityClass;

        // Register auth manager tables
        $this->registerAuthManager();

        // Register translations
        $this->registerTranslations();

    }

    // Registers auth manager for app
    public function registerAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        $authManager->assignmentTable = $this->assignmentTable;
        $authManager->itemChildTable = $this->itemChildTable;
        $authManager->itemTable = $this->itemTable;
        $authManager->ruleTable = $this->ruleTable;
    }

    // Registers translations for the module
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['app/modules/rbac'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => '@vendor/wdmg/yii2-rbac/messages',
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('app/modules/rbac' . $category, $message, $params, $language);
    }
}
