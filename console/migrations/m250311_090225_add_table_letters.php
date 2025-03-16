<?php

use yii\db\Migration;

/**
 * Class m250311_090225_add_table_letters
 */
class m250311_090225_add_table_letters extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = <<<EOF
CREATE TABLE `letters` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `letter` char(4) COLLATE utf8mb4_general_ci NOT NULL,
  `grade` tinyint NOT NULL DEFAULT '11',
  `type` tinyint NOT NULL DEFAULT '1',
  `ignore` tinyint NOT NULL DEFAULT '0',
  `err_cnt` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
EOF;
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250311_090225_add_table_letters cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250311_090225_add_table_letters cannot be reverted.\n";

        return false;
    }
    */
}
