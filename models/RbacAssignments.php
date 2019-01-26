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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{rbac_assignments}}';
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
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => RbacRoles::className(), 'targetAttribute' => ['item_name' => 'name']],
        ];

        if(class_exists('\wdmg\users\models\Users') && isset(Yii::$app->modules['users']))
            $rules[] = [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \wdmg\users\models\Users::className(), 'targetAttribute' => ['user_id' => 'id']];

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
        return $this->hasOne(RbacRoles::className(), ['name' => 'item_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
