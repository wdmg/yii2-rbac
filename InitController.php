<?php

namespace wdmg\rbac\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use yii\rbac\DbManager;
use \wdmg\rbac\rules\AuthorRule;
use \wdmg\rbac\rules\OwnerRule;

class InitController extends Controller
{
    /**
     * @inheritdoc
     */
    public $choice = null;

    /**
     * @inheritdoc
     */
    public $defaultAction = 'index';

    public function options($actionID)
    {
        return ['choice', 'color', 'interactive', 'help'];
    }

    public function actionIndex($params = null)
    {
        $version = Yii::$app->controller->module->version;
        $welcome =
            '╔════════════════════════════════════════════════╗'. "\n" .
            '║                                                ║'. "\n" .
            '║              RBAC MODULE, v.'.$version.'              ║'. "\n" .
            '║          by Alexsander Vyshnyvetskyy           ║'. "\n" .
            '║       (c) 2019-2023 W.D.M.Group, Ukraine       ║'. "\n" .
            '║                                                ║'. "\n" .
            '╚════════════════════════════════════════════════╝';
        echo $name = $this->ansiFormat($welcome . "\n\n", Console::FG_GREEN);
        echo "Select the operation you want to perform:\n";
        echo "  1) Apply all module migrations\n";
        echo "  2) Add base roles and rules for users\n";
        echo "  3) Revert all module migrations\n";
        echo "Your choice: ";

        if(!is_null($this->choice))
            $selected = $this->choice;
        else
            $selected = trim(fgets(STDIN));

        if ($selected == "1") {
            Yii::$app->runAction('migrate/up', ['migrationPath' => '@vendor/wdmg/yii2-rbac/migrations', 'interactive' => true]);
        } else if($selected == "2") {

            // Get auth manager
            $authManager = Yii::$app->getAuthManager();

            // Check if auth manager configured
            if (!$authManager instanceof DbManager) {
                echo $this->ansiFormat("Error! You should configure \"authManager\" component to use database before add roles and rules.\n\n", Console::FG_RED);
                return ExitCode::UNSPECIFIED_ERROR;
            }

            echo $this->ansiFormat("\nDelete the old data from the db... ", Console::FG_YELLOW);

            // Delete the old data from the db
            if($authManager->removeAll())
                echo $this->ansiFormat("Done.\n", Console::FG_GREEN);
            else
                echo $this->ansiFormat("Error!\n", Console::FG_RED);

            // Create and add the roles of admin, editor, manager and simple users
            echo $this->ansiFormat("Create and add the roles... ", Console::FG_YELLOW);

            $role = $authManager->createRole('admin');
            $role->description = 'Administrator role';
            $role->createdAt = \date("Y-m-d H:i:s");
            $role->updatedAt = \date("Y-m-d H:i:s");
            $authManager->add($role);

            $role = $authManager->createRole('editor');
            $role->description = 'Editor role';
            $role->createdAt = \date("Y-m-d H:i:s");
            $role->updatedAt = \date("Y-m-d H:i:s");
            $authManager->add($role);
            
            $role = $authManager->createRole('manager');
            $role->description = 'Content manager role';
            $role->createdAt = \date("Y-m-d H:i:s");
            $role->updatedAt = \date("Y-m-d H:i:s");
            $authManager->add($role);

            $role = $authManager->createRole('user');
            $role->description = 'Default user role';
            $role->createdAt = \date("Y-m-d H:i:s");
            $role->updatedAt = \date("Y-m-d H:i:s");
            $authManager->add($role);

            $role = $authManager->createRole('banned');
            $role->description = 'Blocked user role';
            $role->createdAt = \date("Y-m-d H:i:s");
            $role->updatedAt = \date("Y-m-d H:i:s");
            $authManager->add($role);

            echo $this->ansiFormat("Done.\n", Console::FG_GREEN);


            // Create and add permissions
            echo $this->ansiFormat("Create and add permissions... ", Console::FG_YELLOW);

            $permission = $authManager->createPermission('viewDashboard');
            $permission->description = 'Access permission to view all of modules in dashboard';
            $permission->createdAt = \date("Y-m-d H:i:s");
            $permission->updatedAt = \date("Y-m-d H:i:s");
            $authManager->add($permission);

            $permission = $authManager->createPermission('updateDashboard');
            $permission->description = 'Access permission to edit all of modules in dashboard';
            $permission->createdAt = \date("Y-m-d H:i:s");
            $permission->updatedAt = \date("Y-m-d H:i:s");
            $authManager->add($permission);

            $permission = $authManager->createPermission('updatePosts');
            $permission->description = 'Access permission to edit all posts';
            $permission->createdAt = \date("Y-m-d H:i:s");
            $permission->updatedAt = \date("Y-m-d H:i:s");
            $authManager->add($permission);

            echo $this->ansiFormat("Done.\n", Console::FG_GREEN);


            // Create and add custom access rules
            echo $this->ansiFormat("Create access rules... ", Console::FG_YELLOW);

            $rule = new AuthorRule();
            $rule->createdAt = \date("Y-m-d H:i:s");
            $rule->updatedAt = \date("Y-m-d H:i:s");
            $authManager->add($rule);

            $permission = $authManager->createPermission('updateOwnerPosts');
            $permission->description = 'Access permission to edit posts by owner';
            $permission->ruleName = $rule->name;
            $permission->createdAt = \date("Y-m-d H:i:s");
            $permission->updatedAt = \date("Y-m-d H:i:s");
            $authManager->add($permission);

            echo $this->ansiFormat("Done.\n\n", Console::FG_GREEN);


            // Add permissions as childs of roles
            echo $this->ansiFormat("Add permissions as childs of roles... ", Console::FG_YELLOW);

            $admin = $authManager->getRole('admin');
            $manager = $authManager->getRole('editor');
            $editor = $authManager->getRole('manager');
            $viewDashboard = $authManager->getPermission('viewDashboard');
            $updateDashboard = $authManager->getPermission('updateDashboard');

            // Content manager can view everything
            $authManager->addChild($manager, $viewDashboard);

            // Content manager can update self posts
            $updatePosts = $authManager->getPermission('updatePosts');
            $updateOwnerPosts = $authManager->getPermission('updateOwnerPosts');
            $authManager->addChild($updateOwnerPosts, $updatePosts);

            // Editor can update everything posts
            $authManager->addChild($editor, $updatePosts);

            // Editor can do everything that a content manager can
            $authManager->addChild($editor, $manager);

            // Anyone who can edit everything can also view everything
            $authManager->addChild($updateDashboard, $viewDashboard);

            // Editor can edit everything
            $authManager->addChild($admin, $updateDashboard);

            // Administrator can do everything that a content manager can
            $authManager->addChild($admin, $updatePosts);
            $authManager->addChild($admin, $editor);






            echo $this->ansiFormat("Done.\n\n", Console::FG_GREEN);


            // Assign roles to users
            echo $this->ansiFormat("Assign roles to users... ", Console::FG_YELLOW);

            $admin = $authManager->getRole('admin');
            $authManager->assign($admin, 100);
            
            $editor = $authManager->getRole('editor');
            $authManager->assign($editor, 101);

            $manager = $authManager->getRole('manager');
            $authManager->assign($manager, 102);

            $user = $authManager->getRole('user');
            $authManager->assign($user, 103);

            $banned = $authManager->getRole('banned');
            $authManager->assign($banned, 104);

            echo $this->ansiFormat("Done.\n\n", Console::FG_GREEN);

            echo $this->ansiFormat("Base roles and rules for users inserted successfully.\n\n", Console::FG_GREEN);

        } else if($selected == "3") {
            Yii::$app->runAction('migrate/down', ['migrationPath' => '@vendor/wdmg/yii2-rbac/migrations', 'interactive' => true]);
        } else {
            echo $this->ansiFormat("Error! Your selection has not been recognized.\n\n", Console::FG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        echo "\n";
        return ExitCode::OK;
    }
}