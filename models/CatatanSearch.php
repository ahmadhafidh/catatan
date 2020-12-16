<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Catatan;
use app\models\Users;

/**
 * CatatanSearch represents the model behind the search form of `app\models\Catatan`.
 */
class CatatanSearch extends Catatan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'user_id'], 'integer'],
            [['nama', 'nominal', 'created_at', 'updated_at'], 'safe'],
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
        $query = Catatan::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        // custom searching user_id 
        if(Yii::$app->request->queryParams){
            $user = Users::find()->where(
                ['username' => $params['CatatanSearch']['user_id']]
            )->one();
            $this->user_id = $user->id;
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'nominal', $this->nominal])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'status', $this->status]);
        
         $query->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
