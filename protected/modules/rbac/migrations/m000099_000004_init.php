<?php

use yii\db\Migration;

class m000099_000004_init extends Migration
{
    /**
     * @param string $name
     * @param integer|array $userId
     * @param string|null $description
     * @return \yii\rbac\Role
     * @throws Exception
     */
    public function createRole($name, $userId, $description = null)
    {
        $auth = Yii::$app->authManager;

        $role = $auth->createRole($name);
        $role->description = $description;
        $auth->add($role);

        if (!is_array($userId)) {
            $userId = [$userId];
        }

        foreach ($userId as $id) {
            $auth->assign($role, $id);
        }

        return $role;
    }

    public function up()
    {
        $auth = Yii::$app->authManager;

        $rootRole = $this->createRole('root-role', 1, 'Root role');

        $openAdminPanelPermission = $auth->createPermission('openAdminPanel');
        $openAdminPanelPermission->description = 'Open Admin Panel';
        $auth->add($openAdminPanelPermission);
        $auth->addChild($rootRole, $openAdminPanelPermission);


        $usersRole = $this->createRole('users-role', [1, 2], 'Users role');

        $createCommentPermission = $auth->createPermission('createComment');
        $createCommentPermission->description = 'Create comment';
        $auth->add($createCommentPermission);
        $auth->addChild($usersRole, $createCommentPermission);

        $updateCommentPermission = $auth->createPermission('updateComment');
        $updateCommentPermission->description = 'Update comment';
        $auth->add($updateCommentPermission);
        $auth->addChild($usersRole, $updateCommentPermission);


        $authorRole = $this->createRole('author-role', 1, 'Author role');

        $createPostPermission = $auth->createPermission('createPost');
        $createPostPermission->description = 'Create post';
        $auth->add($createPostPermission);
        $auth->addChild($authorRole, $createPostPermission);

        $updatePostPermission = $auth->createPermission('updatePost');
        $updatePostPermission->description = 'Update post';
        $auth->add($updatePostPermission);
        $auth->addChild($authorRole, $updatePostPermission);


        $this->createRole('moderator-role', 1, 'Moderator role');
    }

    public function down()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
