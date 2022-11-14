<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "zhihu_hot_collection".
 *
 * @property int $id id
 * @property string $title 标题
 * @property string|null $abbr_answer 回答简介
 * @property string|null $content 详细回答
 * @property string $answer_url 回答url
 * @property int $mark
 * @property int $is_recommend 1-待处理 2-推荐 3-不推荐
 * @property int $status 1-有效；2-无效
 * @property string|null $create_time 创建时间
 * @property string|null $update_time 更新时间
 */
class ZhihuHotCollection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zhihu_hot_collection';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['abbr_answer', 'content'], 'string'],
            [['mark', 'is_recommend', 'status'], 'integer'],
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
            'mark' => 'Mark',
            'is_recommend' => '1-待处理 2-推荐 3-不推荐',
            'status' => '1-有效；2-无效',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
