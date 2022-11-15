<?php

use yii\db\Migration;

/**
 * Class m221115_020624_add_admin_user
 */
class m221115_020624_add_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $model = new \backend\models\User();
        $model->username = 'admin';
        $model->setPassword('123456');
        $model->email = $model->username . '@example.com';
        $model->generateAuthKey();
        $model->generateEmailVerificationToken();
        $model->generatePasswordResetToken();
        $model->status = $model::STATUS_ACTIVE;
        $model->created_at = time();
        $model->updated_at = time();
        if ($model->save()) {
            echo 'Add admin user successfully, account: admin, password: 123456' . "\n";
            return true;
        } else {
            echo "Add admin user failed.\n";

            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221115_020624_add_admin_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221115_020624_add_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
