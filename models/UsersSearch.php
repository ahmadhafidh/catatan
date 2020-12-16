<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;

/**
 * UsersSearch represents the model behind the search form of `app\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_by', 'updated_by', 'login_failed'], 'integer'],
            [['username', 'email', 'password', 'auth_key', 'role', 'verification_token', 'password_reset_token', 'created_date', 'created_by_name', 'updated_date', 'updated_by_name', 'last_login_attempt', 'penalty_time', 'kejaksaan_id'], 'safe'],
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
        $query = Users::find();

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
            'created_date' => $this->created_date,
            'created_by' => $this->created_by,
            'updated_date' => $this->updated_date,
            'updated_by' => $this->updated_by,
            'login_failed' => $this->login_failed,
            'last_login_attempt' => $this->last_login_attempt,
            'penalty_time' => $this->penalty_time,
        ]);

        if (!empty($this->kejaksaan_id))
        {
            $query->andFilterWhere([
                'LIKE', "CONCAT(',', kejaksaan_id, ',')", ','.$this->kejaksaan_id.','
            ]);
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'verification_token', $this->verification_token])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'created_by_name', $this->created_by_name])
            ->andFilterWhere(['like', 'updated_by_name', $this->updated_by_name]);

        return $dataProvider;
    }
}
