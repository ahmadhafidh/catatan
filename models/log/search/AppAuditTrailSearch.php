<?php

namespace app\models\log\search;

use Yii; 
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\log\AppAuditTrail;
use app\models\Users;


/**
 * AppAuditTrailSearch represents the model behind the search form of `backend\models\log\AppAuditTrail`.
 */
class AppAuditTrailSearch extends AppAuditTrail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['_id', 'activity', 'old_value', 'new_value', 'action', 'model', 'model_id', 'user_id', 'email', 'ip_address', 'url_referer', 'browser', 'stamp', 'is_error', 'error_desc'], 'safe'],
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

        $query = AppAuditTrail::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->stamp && $this->stamp != '') {
            $date = str_replace(',', '', $this->stamp);
            $date_search = date('Y-m-d', strtotime($date));
            $query->andFilterWhere(['like', 'stamp', $date_search]);
        }

        $user = Users::findByIdOrUsername($this->user_id);

        // grid filtering conditions
        $query
            ->andFilterWhere(['like', 'activity', $this->activity])
            ->andFilterWhere(['like', 'action', $this->action]);
            
            // filtering conditions for search by username or id 
            if($user){
                $query->andFilterWhere(
                    ['OR',
                        ['=', 'user_id', $user->id],
                        ['=', 'user_id', $user->username]
                    ]
                );
            }

        $query->orderBy(['stamp' => SORT_DESC]);

        return $dataProvider;
    }
}
