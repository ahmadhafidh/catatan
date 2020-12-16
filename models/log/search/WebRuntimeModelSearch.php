<?php

namespace app\models\log\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\log\WebRuntimeModel;

/**
 * WebRuntimeModelSearch represents the model behind the search form of `backend\models\log\WebRuntimeModel`.
 */
class WebRuntimeModelSearch extends WebRuntimeModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['_id', 'level', 'category', 'log_time', 'prefix', 'message', 'created_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = WebRuntimeModel::find();

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
        $query->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'log_time', $this->log_time])
            ->andFilterWhere(['like', 'prefix', $this->prefix])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'created_date', $this->created_date]);

        $query->orderBy(['_id' => SORT_DESC]);

        return $dataProvider;
    }
}
