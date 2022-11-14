<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "third_account".
 *
 * @property int $id
 * @property string $appid
 * @property string $name 第三方
 * @property string $pub_key 公钥
 * @property string $pri_key 私钥
 * @property int $status 1-有效；2-删除
 * @property string|null $create_time 创建时间
 * @property string|null $update_time 更新时间
 */
class ThirdAccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'third_account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pub_key', 'pri_key'], 'required'],
            [['pub_key', 'pri_key'], 'string'],
            [['status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['appid', 'name'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'appid' => 'Appid',
            'name' => '第三方',
            'pub_key' => '公钥',
            'pri_key' => '私钥',
            'status' => '1-有效；2-删除',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
