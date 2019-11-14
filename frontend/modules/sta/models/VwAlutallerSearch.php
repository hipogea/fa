<?php

namespace frontend\modules\sta\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sta\models\VwAlutaller;

/**
 * FacultadesSearch represents the model behind the search form of `frontend\modules\sta\models\Facultades`.
 */
class VwAlutallerSearch extends VwAlutaller
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['codfac','codtra', 'ap', 'am', 'nombres',  'codalu', 'dni', 'correo', 'fijos', 'celulares', 'fijos','nomcur'], 'safe'],
     
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
        $query = VwAlutaller::find();

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
        $query->andFilterWhere(['like', 'nombres', $this->nombres])
            ->andFilterWhere(['like', 'ap', $this->ap])
              ->andFilterWhere(['like', 'am', $this->am])
            ->andFilterWhere(['like', 'dni', $this->dni])
           // ->andFilterWhere(['like', 'nombres', $this->nombres])
           ->andFilterWhere(['like', 'correo', $this->correo])
            ->andFilterWhere(['like', 'codalu', $this->codalu])
            //->andFilterWhere(['like', 'dni', $this->dni])
            //->andFilterWhere(['like', 'domicilio', $this->domicilio])
            ->andFilterWhere(['like', 'celulares', $this->celulares])
            //->andFilterWhere(['like', 'nomcur', $this->nomcur])
          ->andFilterWhere(['like', 'codfac', $this->codfac])
        ->andFilterWhere(['like', 'codtra', $this->codtra]);
          //  ->andFilterWhere(['like', 'codperiodo', $this->codperiodo]);

        return $dataProvider;
    }
    
     public function searchByFacultad($params,$codfac)
    {
        $query = VwAlutaller::find();

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
        $query->andFilterWhere(['like', 'ap', $this->ap])
                 ->andFilterWhere(['like', 'am', $this->am])
            ->andFilterWhere(['like', 'dni', $this->dni])
            ->andWhere(['codfac'=>$codfac])
           ->andFilterWhere(['like', 'correo', $this->correo])
            ->andFilterWhere(['like', 'codalu', $this->codalu])
            //->andFilterWhere(['like', 'dni', $this->dni])
            ->andFilterWhere(['like', 'nombres', $this->nombres])
                 ->andFilterWhere(['like', 'celulares', $this->celulares])
            //->andFilterWhere(['like', 'nomcur', $this->nomcur])
          ->andFilterWhere(['like', 'codfac', $this->codfac])
        ->andFilterWhere(['like', 'codtra', $this->codtra]);
           
            //->andFilterWhere(['like', 'nomcur', $this->nomcur])
        //  ->andFilterWhere(['like', 'codfac', $this->codfac])
           // ->andFilterWhere(['like', 'codperiodo', $this->codperiodo]);
        return $dataProvider;
    }
    
}
