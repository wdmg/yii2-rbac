<?php

use yii\db\Migration;
use yii\base\InvalidConfigException;
use yii\rbac\DbManager;

/**
 * Class m190114_193024_rbac
 */
class m190114_193024_rbac extends Migration
{

    /**
     * @throws yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
        return $authManager;
    }

    /**
     * @return boolean
     */
    protected function isMSSQL()
    {
        return $this->db->driverName === 'mssql' || $this->db->driverName === 'sqlsrv' || $this->db->driverName === 'dblib';
    }

    /**
     * @return boolean
     */
    protected function isOracle()
    {
        return $this->db->driverName === 'oci';
    }

    /**
     * @return string
     */
    protected function buildFkClause($delete = '', $update = '')
    {
        if ($this->isMSSQL())
            return '';

        if ($this->isOracle())
            return ' ' . $delete;

        return implode(' ', ['', $delete, $update]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;
        $schema = $this->db->getSchema()->defaultSchema;
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable($authManager->ruleTable, [
            'name' => $this->string(64)->notNull(),
            'data' => $this->binary(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'PRIMARY KEY ([[name]])',
        ], $tableOptions);

        $this->createTable($authManager->itemTable, [
            'name' => $this->string(64)->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64),
            'data' => $this->binary(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'PRIMARY KEY ([[name]])',
        ], $tableOptions);

        $this->addForeignKey(
            'fk_auth_item_to_rules_1',
            $authManager->itemTable,
            'rule_name',
            $authManager->ruleTable,
            'name',
            'SET NULL',
            'CASCADE'
        );

        $this->createTable($authManager->itemChildTable, [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
            'PRIMARY KEY ([[parent]], [[child]])',
        ], $tableOptions);

        $this->addForeignKey(
            'fk_auth_item_child_to_items_1',
            $authManager->itemChildTable,
            'parent',
            $authManager->itemTable,
            'name',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_auth_item_child_to_items_2',
            $authManager->itemChildTable,
            'child',
            $authManager->itemTable,
            'name',
            'CASCADE',
            'CASCADE'
        );

        $this->createTable($authManager->assignmentTable, [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'PRIMARY KEY ([[item_name]], [[user_id]])',
        ], $tableOptions);

        $this->addForeignKey(
            'fk_auth_assignment_to_items_1',
            $authManager->assignmentTable,
            'item_name',
            $authManager->itemTable,
            'name',
            'CASCADE',
            'CASCADE'
        );

        // If exist module `Users` set foreign key `user_id` to `users.id`
        if(class_exists('\wdmg\users\models\Users') && isset(Yii::$app->modules['users'])) {

            $userTable = \wdmg\users\models\Users::tableName();
            $this->addForeignKey(
                'fk_auth_assignment_to_users_1',
                $authManager->assignmentTable,
                'user_id',
                $userTable,
                'id',
                'CASCADE',
                'CASCADE'
            );

        }

        if ($this->isMSSQL()) {
            $this->execute("CREATE TRIGGER {$schema}.trigger_auth_item_child
            ON {$schema}.{$authManager->itemTable}
            INSTEAD OF DELETE, UPDATE
            AS
            DECLARE @old_name VARCHAR (64) = (SELECT name FROM deleted)
            DECLARE @new_name VARCHAR (64) = (SELECT name FROM inserted)
            BEGIN
            IF COLUMNS_UPDATED() > 0
                BEGIN
                    IF @old_name <> @new_name
                    BEGIN
                        ALTER TABLE {$authManager->itemChildTable} NOCHECK CONSTRAINT FK__auth_item__child;
                        UPDATE {$authManager->itemChildTable} SET child = @new_name WHERE child = @old_name;
                    END
                UPDATE {$authManager->itemTable}
                SET name = (SELECT name FROM inserted),
                type = (SELECT type FROM inserted),
                description = (SELECT description FROM inserted),
                rule_name = (SELECT rule_name FROM inserted),
                data = (SELECT data FROM inserted),
                created_at = (SELECT created_at FROM inserted),
                updated_at = (SELECT updated_at FROM inserted)
                WHERE name IN (SELECT name FROM deleted)
                IF @old_name <> @new_name
                    BEGIN
                        ALTER TABLE {$authManager->itemChildTable} CHECK CONSTRAINT FK__auth_item__child;
                    END
                END
                ELSE
                    BEGIN
                        DELETE FROM {$schema}.{$authManager->itemChildTable} WHERE parent IN (SELECT name FROM deleted) OR child IN (SELECT name FROM deleted);
                        DELETE FROM {$schema}.{$authManager->itemTable} WHERE name IN (SELECT name FROM deleted);
                    END
            END;");
        }

        $this->createIndex('{{%idx-auth_assignment-user_id}}', $authManager->assignmentTable, 'user_id');
        $this->createIndex('{{%idx-auth_item-type}}', $authManager->itemTable, 'type');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;

        if ($this->isMSSQL())
            $this->execute('DROP TRIGGER {$schema}.trigger_auth_item_child;');

        $this->dropIndex('{{%idx-auth_assignment-user_id}}', $authManager->assignmentTable);
        $this->dropIndex('{{%idx-auth_item-type}}', $authManager->itemTable);

        $this->dropTable($authManager->assignmentTable);
        $this->dropTable($authManager->itemChildTable);
        $this->dropTable($authManager->itemTable);
        $this->dropTable($authManager->ruleTable);
    }
}
