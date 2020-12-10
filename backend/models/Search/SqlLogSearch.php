<?php

namespace backend\models\Search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SqlLog;

/**
 * SqlLogSearch represents the model behind the search form about `backend\models\SqlLog`.
 */
class SqlLogSearch extends SqlLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'urid', 'status', 'create_time'], 'integer'],
            [['md5key', 'ipaddr', 'params', 'url', 'profile', 'detail', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SqlLog::find()
            ->orderBy([
                'create_time' => SORT_DESC,
            ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (isset($params['datetime']) && !empty($params['datetime'])) {
            $query->andWhere([
                '>=', 'create_time', strtotime($params['datetime'])
            ]);
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'urid' => $this->urid,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'md5key', $this->md5key])
            ->andFilterWhere(['like', 'ipaddr', $this->ipaddr])
            ->andFilterWhere(['like', 'params', $this->params])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'profile', $this->profile])
            ->andFilterWhere(['like', 'detail', $this->detail]);

        return $dataProvider;
    }
}
