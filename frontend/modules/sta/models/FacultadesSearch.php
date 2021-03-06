<?php

namespace frontend\modules\sta\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sta\models\Facultades;

/**
 * FacultadesSearch represents the model behind the search form of `frontend\modules\sta\models\Facultades`.
 */
class FacultadesSearch extends Facultades
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codfac', 'desfac', 'code1', 'code2', 'code3'], 'safe'],
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
        $query = Facultades::find();

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
        $query->andFilterWhere(['like', 'codfac', $this->codfac])
            ->andFilterWhere(['like', 'desfac', $this->desfac])
            ->andFilterWhere(['like', 'code1', $this->code1])
            ->andFilterWhere(['like', 'code2', $this->code2])
            ->andFilterWhere(['like', 'code3', $this->code3]);

        return $dataProvider;
    }
}
