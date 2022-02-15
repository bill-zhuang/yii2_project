<?php

use yii\db\Migration;

/**
 * Class m210401_075012_add_table_zhihu_hot_collection
 */
class m210401_075012_add_table_zhihu_hot_collection extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = <<<EOF
CREATE TABLE `zhihu_hot_collection` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `abbr_answer` text NOT NULL COMMENT '回答简介',
  `content` mediumtext COMMENT '详细回答',
  `answer_url` varchar(128) NOT NULL DEFAULT '' COMMENT '回答url',
  `mark` tinyint(4) NOT NULL DEFAULT '0',
  `is_recommend` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1-待处理 2-推荐 3-不推荐',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '1-有效；2-无效',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_answer_url` (`answer_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='知乎热门收藏表';
EOF;
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210401_075012_add_table_zhihu_hot_collection cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210401_075012_add_table_zhihu_hot_collection cannot be reverted.\n";

        return false;
    }
    */
}
