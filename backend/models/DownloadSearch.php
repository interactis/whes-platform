<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Download;

/**
 * DownloadSearch represents the model behind the search form of `common\models\Download`.
 */
class DownloadSearch extends Download
{
	public $title;
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'content_id', 'order', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'safe'],
            [['hidden'], 'boolean'],
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
        $query = Download::find();
        $query->joinWith('downloadTranslations');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
				'defaultOrder' => ['order' => SORT_ASC]
			]
        ]);
        
        $dataProvider->sort->attributes['title'] = [
			'asc' => ['download_translation.title' => SORT_ASC],
			'desc' => ['download_translation.title' => SORT_DESC],
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
            'content_id' => $this->content_id,
            'order' => $this->order,
            'hidden' => $this->hidden,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'download_translation.language_id' => Yii::$app->params['preferredLanguageId']
        ]);
        
        $query->andFilterWhere(['ilike', 'download_translation.title', $this->title]);

        return $dataProvider;
    }
}
