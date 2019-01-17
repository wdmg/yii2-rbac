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

        if (Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'wdmg\rbac\commands';
        }

        // Register auth manager tables
        $this->registerAuthManager();

        // Register translations
        $this->registerTranslations();

    }

    // Registers auth manager for app
    public function registerAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        $authManager->assignmentTable = '{{%rbac_assignments}}';
        $authManager->itemChildTable = '{{%rbac_item_childs}}';
        $authManager->itemTable = '{{%rbac_items}}';
        $authManager->ruleTable = '{{%rbac_rules}}';
    }

    // Registers translations for the module
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['app/modules/rbac'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/wdmg/yii2-rbac/messages',
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('app/modules/rbac' . $category, $message, $params, $language);
    }
}
