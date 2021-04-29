<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Article;

/**
 * ArticleSearch represents the model behind the search form of `common\models\Article`.
 */
class ArticleSearch extends Article
{
	public $title;
	public $priority;
	public $published;
	public $hidden;
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'content_id', 'created_at', 'updated_at', 'priority'], 'integer'],
            [['title'], 'safe'],
            [['published', 'hidden'], 'boolean']
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
        $query = Article::find();
        $query->leftJoin('article_translation', 'article_translation.article_id = article.id');
        $query->leftJoin('content', 'content.id = article.content_id');
        $query->groupBy(['article.id', 'article_translation.title', 'content.priority', 'content.hidden', 'content.published']);

        // add conditions that should always apply here

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
			'asc' => ['article_translation.title' => SORT_ASC],
			'desc' => ['article_translation.title' => SORT_DESC],
		];
		
		$dataProvider->sort->attributes['priority'] = [
			'asc' => ['priority' => SORT_DESC],
			'desc' => ['priority' => SORT_ASC],
		];
		
		$dataProvider->sort->attributes['published'] = [
			'asc' => ['published' => SORT_ASC],
			'desc' => ['published' => SORT_DESC],
		];
		
		$dataProvider->sort->attributes['hidden'] = [
			'asc' => ['hidden' => SORT_ASC],
			'desc' => ['hidden' => SORT_DESC],
		];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'article.id' => $this->id,
            'content_id' => $this->content_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'priority' => $this->priority,
            'published' => $this->published,
            'hidden' => $this->hidden,
        ]);
        
        $query->andFilterWhere(['ilike', 'article_translation.title', $this->title]);

        return $dataProvider;
    }
}
