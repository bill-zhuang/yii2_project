<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%zhihu_hot_collection}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $abbr_answer
 * @property string $content
 * @property string $answer_url
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class ZhihuHotCollection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%zhihu_hot_collection}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['title'], 'string', 'max' => 256],
            [['abbr_answer'], 'string', 'max' => 1024],
            [['answer_url'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
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
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
                'value' => function ($event) {
                    return date('Y-m-d H:i:s');
                },
            ],
        ];
    }
}
