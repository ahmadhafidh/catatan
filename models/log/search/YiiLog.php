<?php

namespace app\models\log\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\log\YiiLog as YiiLogModel;

/**
 * YiiLog represents the model behind the search form of `backend\models\log\YiiLog`.
 */
class YiiLog extends YiiLogModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['_id', 'level', 'category', 'log_time','message'], 'safe'],
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
        $query = YiiLogModel::find();
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

        $filter = [
            'level' => 1,
            'level' => 2,
        ];
        
        // $query->andFilterWhere(['like', 'type', $this->filter[$this->type]);
    
        $level = (int) $this->level;
        if (in_array($level, [1, 2]))
        {
            $query->andFilterWhere(['level' => $level]);
        } else {
            $query->andFilterWhere(['level' => [1, 2]]);
        }

        $query
            ->andFilterWhere(['log_time' => $this->log_time])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
