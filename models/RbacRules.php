<?php

namespace wdmg\rbac\models;

use Yii;
use \yii\behaviors\TimeStampBehavior;

/**
 * This is the model class for table "rbac_rules".
 *
 * @property string $name
 * @property resource $data
 * @property string $created_at
 * @property string $updated_at
 *
 * @property RbacRoles[] $rbacItems
 */
class RbacRules extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        if(\Yii::$app->getModule('rbac')->ruleTable)
            return Yii::$app->controller->module->ruleTable;
        else
            return '{{%rbac_rules}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => function() {
                    return date("Y-m-d H:i:s");
                }
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['data'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['name'], 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/', 'message' => Yii::t('app/modules/rbac', "Field can contain only latin characters, digits and underscores.")],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app/modules/rbac', 'Rule name'),
            'data' => Yii::t('app/modules/rbac', 'Rule data'),
            'created_at' => Yii::t('app/modules/rbac', 'Created At'),
            'updated_at' => Yii::t('app/modules/rbac', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRbacItems()
    {
        return $this->hasMany(RbacRoles::className(), ['rule_name' => 'name']);
    }

    /**
     * @return array
     */
    public function getAllRules()
    {
        $rules = array();

        $authManager = Yii::$app->getAuthManager();
        foreach ($authManager->getRules() as $name) {
            $rules[] = $name;
        }

        return $rules;
    }
}
