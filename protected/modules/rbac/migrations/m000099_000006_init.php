<?php

use app\modules\rbac\helpers\RBAC;
use yii\db\Migration;

class m000099_000006_init extends Migration
{
    public function up()
    {
        $authManager = Yii::$app->authManager;

        $usersRole = RBAC::createRole('users-role', [1, 2], 'Users role');

        $createCommentPermission = $authManager->createPermission('createComment');
        $createCommentPermission->description = 'Create comment';
        $authManager->add($createCommentPermission);
        $authManager->addChild($usersRole, $createCommentPermission);

        $updateCommentPermission = $authManager->createPermission('updateComment');
        $updateCommentPermission->description = 'Update comment';
        $authManager->add($updateCommentPermission);
        $authManager->addChild($usersRole, $updateCommentPermission);


        $authorRole = RBAC::createRole('author-role', 1, 'Author role');

        $createPostPermission = $authManager->createPermission('createPost');
        $createPostPermission->description = 'Create post';
        $authManager->add($createPostPermission);
        $authManager->addChild($authorRole, $createPostPermission);

        $updatePostPermission = $authManager->createPermission('updatePost');
        $updatePostPermission->description = 'Update post';
        $authManager->add($updatePostPermission);
        $authManager->addChild($authorRole, $updatePostPermission);


        RBAC::createRole('moderator-role', 1, 'Moderator role');
    }
}
