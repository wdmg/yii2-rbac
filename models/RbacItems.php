<?php

namespace wdmg\rbac\models;

use Yii;

/**
 * This is the model class for table "rbac_items".
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
 * @property RbacItemChilds[] $rbacItemChilds
 * @property RbacItemChilds[] $rbacItemChilds0
 * @property RbacItems[] $children
 * @property RbacItems[] $parents
 * @property RbacRules $ruleName
 */
class RbacItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{rbac_items}}';
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
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => RbacRules::className(), 'targetAttribute' => ['rule_name' => 'name']],
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
        return $this->hasMany(RbacAssignments::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['id' => 'user_id'])->viaTable('rbac_assignments', ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRbacItemChilds()
    {
        return $this->hasMany(RbacItemChilds::className(), ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRbacItemChilds0()
    {
        return $this->hasMany(RbacItemChilds::className(), ['child' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(RbacItems::className(), ['name' => 'child'])->viaTable('rbac_item_childs', ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(RbacItems::className(), ['name' => 'parent'])->viaTable('rbac_item_childs', ['child' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(RbacRules::className(), ['name' => 'rule_name']);
    }
}
