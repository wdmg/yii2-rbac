<?php

namespace wdmg\rbac\models;

use Yii;
use \yii\behaviors\TimeStampBehavior;

/**
 * This is the model class for table "rbac_roles".
 *
 * @property string $name
 * @property int $type
 * @property string $description
 * @property string $rule_name
 * @property resource $data
 * @property string $created_at
 * @property string $updated_at
 *
 * @property RbacAssignments[] $rbacAssignments
 * @property Users[] $users
 * @property RbacChilds[] $rbacItemChilds
 * @property RbacChilds[] $rbacItemChilds0
 * @property RbacRoles[] $children
 * @property RbacRoles[] $parents
 * @property RbacRules $ruleName
 */
class RbacRoles extends \yii\db\ActiveRecord
{

    const TYPE_ROLE = 1;
    const TYPE_PERMISSION = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        if(Yii::$app->controller->module->itemTable)
            return Yii::$app->controller->module->itemTable;
        else
            return '{{%rbac_roles}}';
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
            [['name', 'type'], 'required'],
            [['type'], 'integer'],
            [['description', 'data'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['name'], 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/', 'message' => Yii::t('app/modules/rbac', "Field can contain only latin characters, digits and underscores.")],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => RbacRules::class, 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app/modules/rbac', 'Name'),
            'type' => Yii::t('app/modules/rbac', 'Type'),
            'description' => Yii::t('app/modules/rbac', 'Description'),
            'rule_name' => Yii::t('app/modules/rbac', 'Rule Name'),
            'data' => Yii::t('app/modules/rbac', 'Data'),
            'created_at' => Yii::t('app/modules/rbac', 'Created At'),
            'updated_at' => Yii::t('app/modules/rbac', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRbacAssignments()
    {
        return $this->hasMany(RbacAssignments::class, ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::class, ['id' => 'user_id'])->viaTable('rbac_assignments', ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRbacItemParents()
    {
        return $this->hasMany(RbacChilds::class, ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRbacItemChilds()
    {
        return $this->hasMany(RbacChilds::class, ['child' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(RbacRoles::class, ['name' => 'child'])->viaTable('rbac_item_childs', ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(RbacRoles::class, ['name' => 'parent'])->viaTable('rbac_item_childs', ['child' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(RbacRules::class, ['name' => 'rule_name']);
    }

    /**
     * @return array
     */
    public function getAllRoles()
    {
        $roles = array();

        $authManager = Yii::$app->getAuthManager();
        foreach ($authManager->getRoles() as $name) {
            $roles[] = $name;
        }

        return $roles;
    }

    /**
     * @return array
     */
    public function getAllPermissions()
    {
        $permissions = array();

        $authManager = Yii::$app->getAuthManager();
        foreach ($authManager->getPermissions() as $name) {
            $permissions[] = $name;
        }

        return $permissions;
    }

    /**
     * @return array
     */
    public function getAllRolesAndPermissions()
    {
        $roles_permissions = array();

        $authManager = Yii::$app->getAuthManager();
        foreach (array_merge($authManager->getRoles(), $authManager->getPermissions()) as $name) {
            $roles_permissions[] = $name;
        }

        return $roles_permissions;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefault()
    {
        $authManager = Yii::$app->getAuthManager();
        return in_array($this->name, $authManager->defaultRoles);
    }
}
