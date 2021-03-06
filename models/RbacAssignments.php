<?php

namespace wdmg\rbac\models;

use Yii;
use \yii\behaviors\TimeStampBehavior;

/**
 * This is the model class for table "rbac_assignments".
 *
 * @property string $item_name
 * @property int $user_id
 * @property string $created_at
 *
 * @property RbacRoles $itemName
 * @property Users $user
 */
class RbacAssignments extends \yii\db\ActiveRecord
{

    private $_module;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (!($this->_module = Yii::$app->getModule('admin/rbac')))
            $this->_module = Yii::$app->getModule('rbac');

    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        if (Yii::$app->controller->module)
            return Yii::$app->controller->module->assignmentTable;
        else
            return '{{%rbac_assignments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'created_at'
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
        $rules = [
            [['item_name', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['item_name'], 'string', 'max' => 64],
            [['item_name', 'user_id'], 'unique', 'targetAttribute' => ['item_name', 'user_id']],
            [['item_name'], 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/', 'message' => Yii::t('app/modules/rbac', "Field can contain only latin characters, digits and underscores.")],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => RbacRoles::class, 'targetAttribute' => ['item_name' => 'name']],
        ];

        if (class_exists('\wdmg\users\models\Users') && $this->_module->moduleLoaded('users'))
            $rules[] = [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \wdmg\users\models\Users::class, 'targetAttribute' => ['user_id' => 'id']];

        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_name' => Yii::t('app/modules/rbac', 'Item Name'),
            'user_id' => Yii::t('app/modules/rbac', 'User ID'),
            'created_at' => Yii::t('app/modules/rbac', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(RbacRoles::class, ['name' => 'item_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser($user_id = null)
    {
        if (class_exists('\wdmg\users\models\Users') && $this->_module->moduleLoaded('users') && !$user_id)
            return $this->hasOne(\wdmg\users\models\Users::class, ['id' => 'user_id']);
        else if (class_exists('\wdmg\users\models\Users') && $this->_module->moduleLoaded('users') && $user_id)
            return \wdmg\users\models\Users::findOne(['id' => intval($user_id)]);
        else
            return null;
    }
}
