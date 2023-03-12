<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zhihu_salt".
 *
 * @property int $id id
 * @property string $title 标题
 * @property string|null $abbr_answer 回答简介
 * @property string|null $content 详细回答
 * @property string $answer_url 回答url
 * @property int $status 1-有效；2-无效
 * @property string|null $create_time 创建时间
 * @property string|null $update_time 更新时间
 */
class ZhihuSalt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zhihu_salt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['abbr_answer', 'content'], 'string'],
            [['status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['title'], 'string', 'max' => 256],
            [['answer_url'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'title' => '标题',
            'abbr_answer' => '回答简介',
            'content' => '详细回答',
            'answer_url' => '回答url',
            'status' => '1-有效；2-无效',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
