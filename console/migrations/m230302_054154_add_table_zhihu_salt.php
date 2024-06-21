<?php

use yii\db\Migration;

/**
 * Class m230302_054154_add_table_zhihu_salt
 */
class m230302_054154_add_table_zhihu_salt extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = <<<EOF
CREATE TABLE `zhihu_salt` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `abbr_answer` text NOT NULL COMMENT '回答简介',
  `content` mediumtext COMMENT '详细回答',
  `answer_url` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '回答url',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '1-有效；2-无效',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_answer_url` (`answer_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='知乎盐选表';
EOF;
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230302_054154_add_table_zhihu_salt cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230302_054154_add_table_zhihu_salt cannot be reverted.\n";

        return false;
    }
    */
}
