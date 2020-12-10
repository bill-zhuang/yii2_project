<?php

namespace console\models;

class SqlLog extends \common\models\SqlLog
{
    const STATUS_VALID = 1;
    const STATUS_INVALID = 2;

    public function addOne($urid, $ipaddr, $params, $url, $profile, $detail, $createStamp)
    {
        $md5Val = md5($urid . $ipaddr . $url . $detail . $createStamp);
        $model = $this->getRecordByMd5($md5Val);
        if (!isset($model)) {
            $model = new self();
        }
        $model->md5key = $md5Val;
        $model->urid = $urid;
        $model->ipaddr = $ipaddr;
        $model->params = $params;
        $model->url = $url;
        $model->profile = $profile;
        $model->detail = $detail;
        $model->status = 1;
        $model->create_time = $createStamp;
        $model->save();
    }

    public function getRecordByMd5($md5)
    {
        return $this->findOne(['md5key' => $md5]);
    }
}
