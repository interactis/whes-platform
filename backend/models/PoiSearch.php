<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Poi;

/**
 * PoiSearch represents the model behind the search form of `common\models\Poi`.
 */
class PoiSearch extends Poi
{
	public $title;
	public $heritage;
	public $priority;
	public $published;
	public $featured;
	public $hidden;
	public $imported;
	public $tags;
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'content_id', 'priority', 'created_at', 'updated_at'], 'integer'],
            [['title', 'heritage', 'tags'], 'safe'],
            [['published', 'featured', 'hidden', 'imported'], 'boolean']
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
        $query = Poi::find();
        $query->leftJoin('poi_translation', 'poi_translation.poi_id = poi.id');
        $query->leftJoin('content', 'content.id = poi.content_id');
        $query->leftJoin('heritage', 'heritage.id = content.heritage_id');
        $query->leftJoin('heritage_translation', 'heritage_translation.heritage_id = heritage.id');
        
        $query->leftJoin('content_tag', 'content.id = content_tag.content_id');
        $query->leftJoin('tag', 'content_tag.tag_id = tag.id');
        $query->leftJoin('tag_translation', 'tag_translation.tag_id = tag.id');
        
        $query->groupBy(['poi.id', 'poi_translation.title', 'content.priority', 'content.hidden', 'content.featured', 'content.published', 'content.imported', 'heritage_translation.short_name']);

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
			'asc' => ['poi_translation.title' => SORT_ASC],
			'desc' => ['poi_translation.title' => SORT_DESC],
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
		
		$dataProvider->sort->attributes['imported'] = [
			'asc' => ['content.imported' => SORT_ASC],
			'desc' => ['content.imported' => SORT_DESC],
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
            'poi.id' => $this->id,
            'content_id' => $this->content_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'content.priority' => $this->priority,
            'content.published' => $this->published,
            'content.featured' => $this->featured,
            'content.hidden' => $this->hidden,
        	'content.imported' => $this->imported,
            'poi_translation.language_id' => Yii::$app->params['preferredLanguageId'],
            'heritage_translation.language_id' => Yii::$app->params['preferredLanguageId']
        ]);
        
        $query->andFilterWhere(['ilike', 'poi_translation.title', $this->title]);
        $query->andFilterWhere(['ilike', 'heritage_translation.short_name', $this->heritage]);
        $query->andFilterWhere(['like', 'lower(tag_translation.title)', strtolower($this->tags)]);

        return $dataProvider;
    }
}
