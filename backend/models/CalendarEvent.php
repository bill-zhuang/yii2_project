<?php

namespace backend\models;

class CalendarEvent extends \common\models\CalendarEvent
{
    const STATUS_VALID = 1;
    const STATUS_INVALID = 2;

    public function monthData($month)
    {
        $start = $month . '-01';
        $end = date('Y-m-t', strtotime($start));
        $data = $this->find()->asArray()
            ->select(['event', 'start_date', 'start_time', 'end_date', 'end_time'])
            ->where([
                'and',
                ['status' => 1],
                ['>=', 'start_date', $start],
                ['<=', 'start_date', $end],
            ])
            ->all();
        return $data;
    }

    public function startEndData($start, $end)
    {
        $data = $this->find()->asArray()
            ->select(['event', 'start_date', 'start_time', 'end_date', 'end_time'])
            ->where([
                'and',
                ['status' => 1],
                ['>=', 'start_date', $start],
                ['<=', 'start_date', $end],
            ])
            ->all();
        return $data;
    }
}
