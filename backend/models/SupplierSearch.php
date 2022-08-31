<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Supplier;

/**
 * SupplierSearch represents the model behind the search form of `common\models\Supplier`.
 */
class SupplierSearch extends Supplier
{
	public $name;
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'heritage_id', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'safe'],
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
        $query = Supplier::find();
        $query->leftJoin('supplier_translation', 'supplier_translation.supplier_id = supplier.id');
      	$query->groupBy(['supplier.id', 'supplier_translation.name']);

        // add conditions that should always apply here
        
        $user = Yii::$app->user->identity;
    	if (!$user->isAdmin())
        {
        	$query->where(['or',
        		['heritage_id' => $user->heritage_id],
        		//['heritage_id' => null]
        	]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
				'defaultOrder' => ['id' => SORT_DESC]
			],
            'pagination' => [
				'pageSize' => 10,
			]
        ]);
        
        $dataProvider->sort->attributes['name'] = [
			'asc' => ['supplier_translation.name' => SORT_ASC],
			'desc' => ['supplier_translation.name' => SORT_DESC],
		];
		
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'supplier.id' => $this->id,
            'heritage_id' => $this->heritage_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'supplier_translation.language_id' => Yii::$app->params['preferredLanguageId']
        ]);
        
        $query->andFilterWhere(['ilike', 'supplier_translation.name', $this->name]);

        return $dataProvider;
    }
}
