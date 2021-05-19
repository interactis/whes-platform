<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Route;

/**
 * RouteSearch represents the model behind the search form of `common\models\Route`.
 */
class RouteSearch extends Route
{
	public $title;
	public $heritage;
	public $priority;
	public $published;
	public $featured;
	public $hidden;
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'content_id', 'priority', 'created_at', 'updated_at'], 'integer'],
            [['title', 'heritage'], 'safe'],
            [['published', 'featured', 'hidden'], 'boolean']
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
        $query = Route::find();
        $query->leftJoin('route_translation', 'route_translation.route_id = route.id');
        $query->leftJoin('content', 'content.id = route.content_id');
        $query->leftJoin('heritage', 'heritage.id = content.heritage_id');
        $query->leftJoin('heritage_translation', 'heritage_translation.heritage_id = heritage.id');
        $query->groupBy(['route.id', 'route_translation.title', 'content.priority', 'content.hidden', 'content.featured', 'content.published', 'heritage_translation.short_name']);

        // add conditions that should always apply here
        
        $user = Yii::$app->user->identity;
    	if (!$user->isAdmin())
        {
        	$query->where([
        		'content.heritage_id' => $user->heritage_id
        	]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
				'defaultOrder' => ['id' => SORT_DESC]
			],
            'pagination' => [
				'pageSize' => 50,
			]
        ]);
        
        $dataProvider->sort->attributes['title'] = [
			'asc' => ['route_translation.title' => SORT_ASC],
			'desc' => ['route_translation.title' => SORT_DESC],
		];
		
		$dataProvider->sort->attributes['priority'] = [
			'asc' => ['content.priority' => SORT_DESC],
			'desc' => ['content.priority' => SORT_ASC],
		];
		
		$dataProvider->sort->attributes['published'] = [
			'asc' => ['content.published' => SORT_ASC],
			'desc' => ['content.published' => SORT_DESC],
		];
		
		$dataProvider->sort->attributes['featured'] = [
			'asc' => ['content.featured' => SORT_ASC],
			'desc' => ['content.featured' => SORT_DESC],
		];
		
		$dataProvider->sort->attributes['hidden'] = [
			'asc' => ['content.hidden' => SORT_ASC],
			'desc' => ['content.hidden' => SORT_DESC],
		];
		
		$dataProvider->sort->attributes['heritage'] = [
			'asc' => ['heritage_translation.short_name' => SORT_ASC],
			'desc' => ['heritage_translation.short_name' => SORT_DESC],
		];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'route.id' => $this->id,
            'content_id' => $this->content_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'content.priority' => $this->priority,
            'content.published' => $this->published,
            'content.featured' => $this->featured,
            'content.hidden' => $this->hidden,
        ]);
        
        $query->andFilterWhere(['ilike', 'route_translation.title', $this->title]);
        $query->andFilterWhere(['ilike', 'heritage_translation.short_name', $this->heritage]);

        return $dataProvider;
    }
}
