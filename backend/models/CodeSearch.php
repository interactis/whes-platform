<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use common\models\Code;

/**
 * CodeSearch represents the model behind the search form of `common\models\Code`.
 */
class CodeSearch extends Code
{
	public $heritage_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'code_series_id', 'code_group_id', 'content_id', 'type', 'heritage_id', 'created_at', 'updated_at'], 'integer'],
            [['code'], 'safe'],
            [['active'], 'boolean'],
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
        $query = Code::find()->joinWith('codeGroup');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
				'defaultOrder' => ['id' => SORT_ASC],
				'attributes' => ['id', 'code', 'type', 'active']
			],
            'pagination' => [
				'pageSize' => 50,
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
            'code.code_series_id' => $this->code_series_id,
            'code_group_id' => $this->code_group_id,
            'content_id' => $this->content_id,
            'type' => $this->type,
            'active' => $this->active,
            'code_group.heritage_id' => $this->heritage_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'code', $this->code]);

        return $dataProvider;
    }
    
    public function getDownloadData($dataProvider)
    {
    	$data = [];
    	foreach ($dataProvider->getModels() as $model)
    	{
    		 $data[] = [
    		 	'url' => Yii::$app->params['frontendUrl'] .'code/'. $model->code,
    		 	'code' => $model->code,
    		 	'code group' => (isset($model->codeGroup) ? $model->codeGroup->title : '')
    		 ];
    	}
    	
		return new ArrayDataProvider([
			'allModels' => $data,
			'pagination' => [
				'pageSize' => false,
			]
		]);
    }
}
