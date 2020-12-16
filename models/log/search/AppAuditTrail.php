<?php

namespace app\models\log\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\log\AppAuditTrail as AppAuditTrailModel;

/**
 * AppAuditTrail represents the model behind the search form of `backend\models\log\AppAuditTrail`.
 */
class AppAuditTrail extends AppAuditTrailModel
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
        $query = AppAuditTrailModel::find();

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
            ->andFilterWhere(['like', 'activity', $this->activity])
            ->andFilterWhere(['like', 'old_value', $this->old_value])
            ->andFilterWhere(['like', 'new_value', $this->new_value])
            ->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'model_id', $this->model_id])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'ip_address', $this->ip_address])
            ->andFilterWhere(['like', 'url_referer', $this->url_referer])
            ->andFilterWhere(['like', 'browser', $this->browser])
            ->andFilterWhere(['like', 'stamp', $this->stamp])
            ->andFilterWhere(['like', 'is_error', $this->is_error])
            ->andFilterWhere(['like', 'error_desc', $this->error_desc]);

        return $dataProvider;
    }
}
