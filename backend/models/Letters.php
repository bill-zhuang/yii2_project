<?php

namespace backend\models;


class Letters extends \common\models\Letters
{
    public static $gradeList = [
        11 => '一年级上', 12 => '一年级下'
    ];

    public static $typeList = [
        1 => '一类字', 2 => '二类字'
    ];

    public function randLetter(array $params, $limit = 30)
    {
        $maxId = '';
        if (!empty($params['letter_end'])) {
            $one = Letters::find()->asArray()
                ->select('id')
                ->where(['letter' => $params['letter_end']])
                ->orderBy(['id' => SORT_DESC])
                ->one();
            if ($one) {
                $maxId = $one['id'];
            } else {
                $maxId = 0;
            }
        }
        $grade = '';
        if (!empty($params['grade'])) {
            $grade = $params['grade'];
        }
        $type = '';
        if (!empty($params['type'])) {
            $type = $params['type'];
            if ($type == 1) {
                $type = [1, 3];
            } else {
                $type = [2, 3];
            }
        }
        $errCnt = '';
        if (!empty($params['flag_err'])) {
            $errCnt = 0;
        }
        return Letters::find()->asArray()
            ->select('id as lid, letter, type, err_cnt')
            ->where(['ignore' => 0])
            ->andFilterWhere(['grade' => $grade])
            ->andFilterWhere(['type' => $type])
            ->andFilterWhere(['<=', 'id', $maxId])
            ->andFilterWhere(['>', 'err_cnt', $errCnt])
            ->orderBy('rand()')
            ->limit($limit)->all();
    }
}
