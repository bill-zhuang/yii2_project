<?php

use yii\db\Migration;

/**
 * Class m210401_075106_add_table_calendar_event
 */
class m210401_075106_add_table_calendar_event extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = <<<EOF
CREATE TABLE `calendar_event` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `event` varchar(32) NOT NULL DEFAULT '' COMMENT '事项',
  `start_date` date NOT NULL COMMENT '开始日期',
  `start_time` varchar(8) NOT NULL DEFAULT '' COMMENT '开始时间',
  `end_date` date NOT NULL COMMENT '结束日期',
  `end_time` varchar(8) NOT NULL DEFAULT '' COMMENT '结束时间',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '1-有效；2-无效',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_start_date_time` (`start_date`,`start_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='日历';
EOF;
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210401_075106_add_table_calendar_event cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210401_075106_add_table_calendar_event cannot be reverted.\n";

        return false;
    }
    */
}
