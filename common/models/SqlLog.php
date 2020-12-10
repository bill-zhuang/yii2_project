<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sql_log".
 *
 * @property int $id id
 * @property string $md5key md5 urid+ipaddr+url+detail_create_time
 * @property int $urid urid
 * @property string $ipaddr ip address
 * @property string $params 参数
 * @property string $url url
 * @property string $profile
 * @property string $detail 操作说明
 * @property int $status 1-有效；2-无效
 * @property int $create_time 创建时间
 * @property string|null $update_time 更新时间
 */
class SqlLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sql_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['urid', 'detail', 'create_time'], 'required'],
            [['urid', 'status', 'create_time'], 'integer'],
            [['detail'], 'string'],
            [['update_time'], 'safe'],
            [['md5key', 'profile'], 'string', 'max' => 64],
            [['ipaddr'], 'string', 'max' => 32],
            [['params'], 'string', 'max' => 1024],
            [['url'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'md5key' => 'md5 urid+ipaddr+url+detail_create_time',
            'urid' => 'urid',
            'ipaddr' => 'ip address',
            'params' => '参数',
            'url' => 'url',
            'profile' => 'Profile',
            'detail' => '操作说明',
            'status' => '1-有效；2-无效',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
