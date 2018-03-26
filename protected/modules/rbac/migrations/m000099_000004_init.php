<?php

use yii\db\Migration;

class m000099_000004_init extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        $rootRole = $auth->createRole('root-role');
        $rootRole->description = 'Root role';
        $auth->add($rootRole);
        $auth->assign($rootRole, 1);

        $usersRole = $auth->createRole('users-role');
        $usersRole->description = 'Users role';
        $auth->add($usersRole);
        $auth->addChild($rootRole, $usersRole);

        $authorRole = $auth->createRole('author-role');
        $authorRole->description = 'Author role';
        $auth->add($authorRole);

        $createPostPermission = $auth->createPermission('createPost');
        $createPostPermission->description = 'Create a post';
        $auth->add($createPostPermission);

        $updatePostPermission = $auth->createPermission('updatePost');
        $updatePostPermission->description = 'Update post';
        $auth->add($updatePostPermission);

        $auth->addChild($authorRole, $createPostPermission);
        $auth->addChild($authorRole, $updatePostPermission);

        $auth->assign($rootRole, 2);
        $auth->assign($authorRole, 2);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
