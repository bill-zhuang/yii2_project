<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "calendar_event".
 *
 * @property int $id id
 * @property string $event 事项
 * @property string $start_date 开始日期
 * @property string $start_time 开始时间
 * @property string $end_date 结束日期
 * @property string $end_time 结束时间
 * @property int $status 1-有效；2-无效
 * @property string|null $create_time 创建时间
 * @property string|null $update_time 更新时间
 */
class CalendarEvent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calendar_event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_date', 'end_date'], 'required'],
            [['start_date', 'end_date', 'create_time', 'update_time'], 'safe'],
            [['status'], 'integer'],
            [['event'], 'string', 'max' => 32],
            [['start_time', 'end_time'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'event' => '事项',
            'start_date' => '开始日期',
            'start_time' => '开始时间',
            'end_date' => '结束日期',
            'end_time' => '结束时间',
            'status' => '1-有效；2-无效',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
