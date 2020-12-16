<?php

namespace app\models\log\search;

use Yii; 
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\log\YiiLog;

/**
 * YiiLogSearch represents the model behind the search form of `backend\models\log\YiiLog`.
 */
class YiiLogSearch extends YiiLog
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
        $this->load($params);

        //var_dump($this->user_id);
        //exit;

        $query = YiiLog::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        // grid filtering conditions
       
        // var_dump($this->level);
        // exit;
        $level = (int) $this->level;
        if (in_array($level, [1, 2]))
        {
            $query->andFilterWhere(['level' => $level]);
        } else {
            $query->andFilterWhere(['level' => [1, 2]]);
        }

        $LogTime = \DateTime::createFromFormat('d-m-Y H:i:s', $this->log_time.' 00:00:00');

        if ($LogTime !== false)
        {
            $nextDay = date('d-m-Y', strtotime($this->log_time.' +1 day'));
            $logtimeEnd =\DateTime::createFromFormat('d-m-Y H:i:s', $nextDay.' 00:00:00');
            $query->andFilterWhere(['>=', 'log_time', $LogTime->getTimestamp()]);
            $query->andFilterWhere(['<', 'log_time', $logtimeEnd->getTimestamp()]);
        }
        $query
            // ->andFilterWhere(['log_time' => $this->log_time])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'message', $this->message]);


        return $dataProvider;
    }
}
