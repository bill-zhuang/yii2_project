<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%letters}}".
 *
 * @property int $id
 * @property string $letter
 * @property int $grade
 * @property int $type
 * @property int $ignore
 * @property int $err_cnt
 */
class Letters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%letters}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['letter'], 'required'],
            [['grade', 'type', 'ignore', 'err_cnt'], 'integer'],
            [['letter'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'letter' => 'Letter',
            'grade' => 'Grade',
            'type' => 'Type',
            'ignore' => 'Ignore',
            'err_cnt' => 'Err Cnt',
        ];
    }
}
