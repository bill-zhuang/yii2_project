<?php

namespace backend\models\Search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Letters;

/**
 * LettersSearch represents the model behind the search form about `backend\models\Letters`.
 */
class LettersSearch extends Letters
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'grade', 'type', 'ignore', 'err_cnt'], 'integer'],
            [['letter'], 'safe'],
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
        $query = Letters::find()
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
            'grade' => $this->grade,
            'type' => $this->type,
            'ignore' => $this->ignore,
            'err_cnt' => $this->err_cnt,
        ]);

        $query->andFilterWhere(['like', 'letter', $this->letter]);

        return $dataProvider;
    }
}
