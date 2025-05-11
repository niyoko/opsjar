<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Report;

/**
 * ReportSearch represents the model behind the search form of `backend\models\report`.
 */
class ReportSearch extends report
{
    public $bulan;
    public $name;
    public $pg;
    public $c;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_provinsi', 'status', 'pg'], 'integer'],
            [['date', 'surat_tugas', 'created_at', 'updated_at', 'created_by','bulan', 'name', 'tahun', 'c'], 'safe'],
            [['udara', 'laut', 'darat', 'total'], 'number'],
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
        $query = Report::find();

        // add conditions that should always apply here

        if($this->bulan){
            $query->andWhere(['MONTH(date)' => $this->bulan]);
        }

        if($this->name){
            $query->join('join', 'provinsi', 'report.id_provinsi = provinsi.id');
            $query->andWhere(['like', 'provinsi.name', $this->name]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ]
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
            'id_provinsi' => $this->id_provinsi,
            'date' => $this->date,
            'udara' => $this->udara,
            'laut' => $this->laut,
            'darat' => $this->darat,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'tahun' => $this->tahun,
        ]);

        

        $query->andFilterWhere(['like', 'surat_tugas', $this->surat_tugas])
            ->andFilterWhere(['like', 'created_by', $this->created_by]);

        return $dataProvider;
    }

    public function searchUser($params)
    {
        $query = Report::find();

        // add conditions that should always apply here

        if($this->bulan){
            $query->andWhere(['MONTH(date)' => $this->bulan]);
        }

        if($this->name){
            $query->join('join', 'provinsi', 'report.id_provinsi = provinsi.id');
            $query->andWhere(['like', 'provinsi.name', $this->name]);
        }
        
        if($this->c){
            switch ($this->c) {
                case 'darat':
                    $query->andWhere(['>', 'report.darat', 0]);
                    break;

                case 'udara':
                    $query->andWhere(['>', 'report.udara', 0]);
                    break;

                case 'laut':
                    $query->andWhere(['>', 'report.laut', 0]);
                    break;
                
                default:
                    # code...
                    break;
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
                'page' => $this->pg
            ]
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
            'id_provinsi' => $this->id_provinsi,
            'date' => $this->date,
            'udara' => $this->udara,
            'laut' => $this->laut,
            'darat' => $this->darat,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'tahun' => $this->tahun,
        ]);

        

        $query->andFilterWhere(['like', 'surat_tugas', $this->surat_tugas])
            ->andFilterWhere(['like', 'created_by', $this->created_by]);

        return $dataProvider;
    }
}
