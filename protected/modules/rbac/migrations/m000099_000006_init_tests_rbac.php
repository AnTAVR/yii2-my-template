<?php

use app\modules\rbac\helpers\RBAC;
use yii\db\Migration;

class m000099_000006_init_tests_rbac extends Migration
{
    public function up()
    {
        $authManager = Yii::$app->authManager;

        $name = 'users-role';
        $time = $this->beginCommand("RBAC::createRole '{$name}'");
        $usersRole = RBAC::createRole($name, [1, 2], RBAC::name2description($name));
        $this->endCommand($time);

        $name = 'createComment';
        $time = $this->beginCommand("RBAC::createPermission '{$name}'");
        $createCommentPermission = $authManager->createPermission($name);
        $createCommentPermission->description = RBAC::name2description($name);
        $authManager->add($createCommentPermission);
        $authManager->addChild($usersRole, $createCommentPermission);
        $this->endCommand($time);

        $name = 'updateComment';
        $time = $this->beginCommand("RBAC::createPermission '{$name}'");
        $updateCommentPermission = $authManager->createPermission($name);
        $updateCommentPermission->description = RBAC::name2description($name);
        $authManager->add($updateCommentPermission);
        $authManager->addChild($usersRole, $updateCommentPermission);
        $this->endCommand($time);

        $name = 'author-role';
        $time = $this->beginCommand("RBAC::createRole '{$name}'");
        $authorRole = RBAC::createRole($name, 1, RBAC::name2description($name));
        $this->endCommand($time);

        $name = 'createPost';
        $time = $this->beginCommand("RBAC::createPermission '{$name}'");
        $createPostPermission = $authManager->createPermission($name);
        $createPostPermission->description = RBAC::name2description($name);
        $authManager->add($createPostPermission);
        $authManager->addChild($authorRole, $createPostPermission);
        $this->endCommand($time);

        $name = 'updatePost';
        $time = $this->beginCommand("RBAC::createPermission '{$name}'");
        $updatePostPermission = $authManager->createPermission($name);
        $updatePostPermission->description = RBAC::name2description($name);
        $authManager->add($updatePostPermission);
        $authManager->addChild($authorRole, $updatePostPermission);
        $this->endCommand($time);

        $name = 'moderator-role';
        $time = $this->beginCommand("RBAC::createRole '{$name}'");
        RBAC::createRole($name, 1, RBAC::name2description($name));
        $this->endCommand($time);
    }

    public function down()
    {
        $authManager = Yii::$app->authManager;

        $authManager->remove($authManager->getRole('users-role'));
        $authManager->remove($authManager->getPermission('createComment'));
        $authManager->remove($authManager->getPermission('updateComment'));

        $authManager->remove($authManager->getRole('author-role'));
        $authManager->remove($authManager->getPermission('createPost'));
        $authManager->remove($authManager->getPermission('updatePost'));

        $authManager->remove($authManager->getRole('moderator-role'));
    }
}
