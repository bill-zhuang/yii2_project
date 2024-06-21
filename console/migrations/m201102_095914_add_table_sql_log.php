<?php

use yii\db\Migration;

/**
 * Class m201102_095914_add_table_sql_log
 */
class m201102_095914_add_table_sql_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = <<<EOF
CREATE TABLE `sql_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `md5key` varchar(64) NOT NULL DEFAULT '' COMMENT 'md5 urid+ipaddr+url+detail_create_time',
  `urid` int(11) NOT NULL COMMENT 'urid',
  `ipaddr` varchar(32) NOT NULL DEFAULT '' COMMENT 'ip address',
  `params` varchar(1024) NOT NULL DEFAULT '' COMMENT '参数',
  `url` varchar(128) NOT NULL DEFAULT '' COMMENT 'url',
  `profile` varchar(64) NOT NULL DEFAULT '',
  `detail` text NOT NULL COMMENT '操作说明',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '1-有效；2-无效',
  `create_time` int(11) unsigned NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_urid` (`urid`) USING BTREE,
  KEY `idx_create_time` (`create_time`) USING BTREE,
  KEY `idx_md5key` (`md5key`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='sql log表';
EOF;
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201102_095914_add_table_sql_log cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201102_095914_add_table_sql_log cannot be reverted.\n";

        return false;
    }
    */
}
