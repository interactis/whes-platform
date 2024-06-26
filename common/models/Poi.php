<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\HelperModel;
use common\components\SwissGeometryBehavior;
use nanson\postgis\helpers\GeoJsonHelper;

/**
 * This is the model class for table "poi".
 *
 * @property int $id
 * @property int $external_id
 * @property int|null $content_id
 * @property string|null $arrival_station
 * @property string|null $arrival_url
 * @property string|null $geom
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property AmbassadorTranslation[] $ambassadorTranslations
 * @property Content $content
 * @property PoiTranslation[] $poiTranslations
 */
class Poi extends HelperModel
{
	public $translationFields = ['title', 'slug', 'description', 'youtube_id', 'vimeo_id', 'directions', 'remarks', 'ticket_title', 'ticket_button_url', 'ticket_button_text', 'ticket_remarks'];
	public $requiredTranslationFields = ['title', 'description'];
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'poi';
    }
    
    public static function pluralName()
    {
        return Yii::t('app', 'Points of Interest');
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => SwissGeometryBehavior::className(),
                'type' => SwissGeometryBehavior::GEOMETRY_POINT,
                'attribute' => 'geom',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'external_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['content_id', 'external_id', 'created_at', 'updated_at'], 'integer'],
            [['arrival_station', 'arrival_url'], 'string', 'max' => 255],
            [['arrival_url'], 'url'],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
            [['tags'], 'required'],
            
            ['visitorFlags', 'required', 'when' => function ($model) {
				if (empty($model->eduFlags) && empty($model->eutFlags)) {
					return true;
				}
			}],
			['eduFlags', 'required', 'when' => function ($model) {
				if (empty($model->visitorFlags) && empty($model->eutFlags)) {
					return true;
				}
			}],

            [['childContentIds', 'eutFlags'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'external_id' => Yii::t('app', 'External ID'),
            'content_id' => Yii::t('app', 'Content ID'),
            'arrival_station' => Yii::t('app', 'SBB Arrival Station Name'),
            'arrival_url' => Yii::t('app', 'Arrival Station URL'),
            'geom' => Yii::t('app', 'Geom'),
            'visitorFlags' =>  Yii::t('app', 'Visitor Filters'),
            'eduFlags' =>  Yii::t('app', 'EDU Filters'),
            'eutFlags' =>  Yii::t('app', 'Eiger Ultra Trail Filters'),
            'childContentIds' => Yii::t('app', 'Child Content'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    /**
     * @param $geom
     * Store array to postgis geometry field.
     */
    public function setGeom($geom)
    {
        $this->geom = $geom;
    }

    /**
     * Gets query for [[AmbassadorTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAmbassadorTranslations()
    {
        return $this->hasMany(AmbassadorTranslation::className(), ['poi_id' => 'id']);
    }

    /**
     * Gets query for [[Content]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }

    /**
     * Gets query for [[PoiTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPoiTranslations()
    {
        return $this->hasMany(PoiTranslation::className(), ['poi_id' => 'id']);
    }
    
    public function getLabel()
    {
    	$html = $this->getFlagLabel(Yii::t('app', 'Point of interest'));
    	
    	if (isset($this->content->heritage))
    		$html .= '<br /><em>'. $this->content->heritage->short_name .'</em>';
    		
    	return $html;
    }
    
    public function getPoiRoute()
    {    	
		if ($geometry = SwissGeometryBehavior::toGeometry($this->type, $this->geom))
		{
			return Route::find()
    			->joinWith('content')
    			->where('ST_DWithin(geom, '. $geometry .', '. \Yii::$app->params['routePoiBuffer'] .')')
    			->andWhere(['published' => true, 'hidden' => false, 'archive' => false, 'approved' => true])
    			->one();
    	}
    	return false;
    }
}
