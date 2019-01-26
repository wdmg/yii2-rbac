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
        return '{{rbac_rules}}';
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app/modules/rbac', 'Name'),
            'data' => Yii::t('app/modules/rbac', 'Data'),
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
}
