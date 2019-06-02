<?php

namespace wdmg\rbac\models;

use Yii;

/**
 * This is the model class for table "rbac_item_childs".
 *
 * @property string $parent
 * @property string $child
 *
 * @property RbacRoles $parent0
 * @property RbacRoles $child0
 */
class RbacChilds extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        if(Yii::$app->controller->module->itemChildTable)
            return Yii::$app->controller->module->itemChildTable;
        else
            return '{{%rbac_childs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['parent', 'child'], 'unique', 'targetAttribute' => ['parent', 'child']],
            [['parent', 'child'], 'match', 'pattern' => '/^[a-zA-Z0-9_]+$/', 'message' => Yii::t('app/modules/rbac', "Field can contain only latin characters, digits and underscores.")],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => RbacRoles::className(), 'targetAttribute' => ['parent' => 'name']],
            [['child'], 'exist', 'skipOnError' => true, 'targetClass' => RbacRoles::className(), 'targetAttribute' => ['child' => 'name']],
            ['child', 'compare', 'compareAttribute' => 'parent', 'operator' => '!==', 'message' => Yii::t('app/modules/rbac', "Child and parent don't have to match.")],
            ['parent', 'compare', 'compareAttribute' => 'child', 'operator' => '!==', 'message' => Yii::t('app/modules/rbac', "Parent and child don't have to match.")],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'parent' => Yii::t('app/modules/rbac', 'Parent'),
            'child' => Yii::t('app/modules/rbac', 'Child'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(RbacRoles::className(), ['name' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild()
    {
        return $this->hasOne(RbacRoles::className(), ['name' => 'child']);
    }

}
