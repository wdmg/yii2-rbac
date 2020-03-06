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
            '║       (c) 2019-2020 W.D.M.Group, Ukraine       ║'. "\n" .
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


            echo $this->ansiFormat("Create and add the roles... ", Console::FG_YELLOW);

            // Create and add the roles of admin, editor and simple users
            $admin = $authManager->createRole('admin');
            $admin->createdAt = \date("Y-m-d H:i:s");
            $admin->updatedAt = \date("Y-m-d H:i:s");


            $admin->createdAt = \date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -1 days" . " -2 hours"));
            $admin->updatedAt = \date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -1 days" . " -2 hours"));

            $authManager->add($admin);

            $editor = $authManager->createRole('editor');
            $editor->createdAt = \date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -1 days" . " -2 hours"));
            $editor->updatedAt = \date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -1 days" . " -2 hours"));
            $authManager->add($editor);

            $manager = $authManager->createRole('manager');
            $manager->createdAt = \date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -1 days" . " -2 hours"));
            $manager->updatedAt = \date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -1 days" . " -2 hours"));
            $authManager->add($manager);

            $guest = $authManager->createRole('guest');
            $guest->createdAt = \date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -1 days" . " -2 hours"));
            $guest->updatedAt = \date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -1 days" . " -2 hours"));
            $authManager->add($guest);

            echo $this->ansiFormat("Done.\n", Console::FG_GREEN);


            echo $this->ansiFormat("Create rules... ", Console::FG_YELLOW);

            // Create and rules
            $authorRule = new AuthorRule();
            $authorRule->createdAt = \date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -1 days" . " -2 hours"));
            $authorRule->updatedAt = \date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -1 days" . " -2 hours"));
            $authManager->add($authorRule);

            $ownerRule = new OwnerRule();
            $ownerRule->createdAt = \date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -1 days" . " -2 hours"));
            $ownerRule->updatedAt = \date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -1 days" . " -2 hours"));
            $authManager->add($ownerRule);

            echo $this->ansiFormat("Done.\n", Console::FG_GREEN);


            echo $this->ansiFormat("Create and add rules, permissions... ", Console::FG_YELLOW);

            // Create and add rules, permissions
            $editAdminPages = $authManager->createPermission('editAdminPages');
            $editAdminPages->description = 'Access to edit data from admin pages';
            $editAdminPages->ruleName = $authorRule->name;
            $editAdminPages->createdAt = \date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -1 days" . " -2 hours"));
            $editAdminPages->updatedAt = \date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -1 days" . " -2 hours"));
            $authManager->add($editAdminPages);

            $viewAdminPages = $authManager->createPermission('viewAdminPages');
            $viewAdminPages->description = 'Access to view data from admin pages';
            $viewAdminPages->ruleName = $ownerRule->name;
            $viewAdminPages->createdAt = \date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -1 days" . " -2 hours"));
            $viewAdminPages->updatedAt = \date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " -1 days" . " -2 hours"));
            $authManager->add($viewAdminPages);

            // Editor can edit information from admin pages
            $authManager->addChild($editor, $editAdminPages);

            // Admin inherits the role of editor and can view and edit information from admin pages
            $authManager->addChild($admin, $editor);

            // Admin and manager can view admin pages
            $authManager->addChild($admin, $viewAdminPages);
            $authManager->addChild($manager, $viewAdminPages);

            echo $this->ansiFormat("Done.\n", Console::FG_GREEN);


            echo $this->ansiFormat("Assign roles to users... ", Console::FG_YELLOW);

            // Assign roles to users
            $assigned = $authManager->assign($admin, 100);
            $assigned = $authManager->assign($editor, 101);
            $assigned = $authManager->assign($manager, 102);

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