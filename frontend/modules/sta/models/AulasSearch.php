<?php

namespace frontend\modules\sta\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sta\models\Aulas;

/**
 * AulasSearch represents the model behind the search form of `frontend\modules\sta\models\Aulas`.
 */
class AulasSearch extends Aulas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cap'], 'integer'],
            [['codaula', 'codfac', 'pabellon'], 'safe'],
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
        $query = Aulas::find();

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
            'cap' => $this->cap,
        ]);

        $query->andFilterWhere(['like', 'codaula', $this->codaula])
            ->andFilterWhere(['like', 'codfac', $this->codfac])
            ->andFilterWhere(['like', 'pabellon', $this->pabellon]);

        return $dataProvider;
    }
}
