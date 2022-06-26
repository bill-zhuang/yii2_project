<?php

namespace backend\models\Search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ThirdAccount;

/**
 * ThirdAccountSearch represents the model behind the search form about `backend\models\ThirdAccount`.
 */
class ThirdAccountSearch extends ThirdAccount
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['appid', 'name', 'pub_key', 'pri_key', 'create_time', 'update_time'], 'safe'],
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
        $query = ThirdAccount::find()
            ->andWhere([
                'status' => self::STATUS_VALID,
            ])
            ->orderBy([
                'id' => SORT_DESC,
            ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'appid', $this->appid])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'pub_key', $this->pub_key])
            ->andFilterWhere(['like', 'pri_key', $this->pri_key]);

        return $dataProvider;
    }
}
