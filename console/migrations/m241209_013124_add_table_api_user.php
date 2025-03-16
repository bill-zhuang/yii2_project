<?php

use yii\db\Migration;

/**
 * Class m241209_013124_add_table_api_user
 */
class m241209_013124_add_table_api_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = <<<EOF
CREATE TABLE `api_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '10',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_username` (`username`) USING BTREE,
  KEY `idx_token` (`token`),
  KEY `idx_auth_key` (`auth_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
EOF;
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241209_013124_add_table_api_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241209_013124_add_table_api_user cannot be reverted.\n";

        return false;
    }
    */
}
