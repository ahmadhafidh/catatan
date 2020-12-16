<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WebSession;

/**
 * WebSessionSearch represents the model behind the search form of `app\models\WebSession`.
 */
class WebSessionSearch extends WebSession
{
    public $type;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'data'], 'safe'],
            [['user_id'], 'integer'],
            [['expire'], 'string'],
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
        $query = WebSession::find();

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
            'user_id' => $this->user_id,
        ]);
        
        $expireStart = \DateTime::createFromFormat('d-m-Y H:i:s', $this->expire.' 00:00:00');

        if ($expireStart !== false)
        {
            $nextDay = date('d-m-Y', strtotime($this->expire.' +1 day'));
            $expireEnd =\DateTime::createFromFormat('d-m-Y H:i:s', $nextDay.' 00:00:00');
            $query->andFilterWhere(['>=', 'expire', $expireStart->getTimestamp()]);
            $query->andFilterWhere(['<', 'expire', $expireEnd->getTimestamp()]);
        }

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'data', $this->data]);
        
        return $dataProvider;
    }
}
