<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProfileItem;

/**
 * ProfileItemSearch represents the model behind the search form of `common\models\ProfileItem`.
 */
class ProfileItemSearch extends ProfileItem
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'heritage_id', 'order', 'created_at', 'updated_at'], 'integer'],
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
        $query = ProfileItem::find();
        $query->leftJoin('profile_item_translation', 'profile_item_translation.profile_item_id = profile_item.id');
		$query->groupBy(['profile_item.id', 'profile_item_translation.title']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
				'defaultOrder' => ['order' => SORT_ASC]
			],
            'pagination' => [
				'pageSize' => 20,
			]
        ]);
        
        $dataProvider->sort->attributes['title'] = [
			'asc' => ['profile_item_translation.title' => SORT_ASC],
			'desc' => ['profile_item_translation.title' => SORT_DESC],
		];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'heritage_id' => $this->heritage_id,
            'order' => $this->order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        //$query->andFilterWhere(['ilike', 'profile_item_translation.title', $this->title]);

        return $dataProvider;
    }
}
