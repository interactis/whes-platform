<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\helpers\HelperModel;
use common\components\SwissGeometryBehavior;
use nanson\postgis\helpers\GeoJsonHelper;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property int|null $content_id
 * @property string|null $from
 * @property string|null $to
 * @property string|null $arrival_station
 * @property string|null $arrival_url
 * @property string|null $geom
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Content $content
 * @property EventTranslation[] $eventTranslations
 */
class Event extends HelperModel
{
	public $translationFields = ['title', 'slug', 'description', 'schedule', 'youtube_id', 'vimeo_id', 'directions', 'remarks'];
	public $requiredTranslationFields = ['title', 'description'];
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }
    
    public static function pluralName()
    {
        return Yii::t('app', 'Events');
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
            [['content_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['content_id', 'created_at', 'updated_at'], 'integer'],
            [['from', 'to'], 'required'],
            [['arrival_station', 'arrival_url'], 'string', 'max' => 255],
            [['arrival_url'], 'url'],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
            [['tags', 'flags'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content_id' => Yii::t('app', 'Content ID'),
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To'),
            'arrival_station' => Yii::t('app', 'SBB Arrival Station Name'),
            'arrival_url' => Yii::t('app', 'Arrival Station URL'),
            'geom' => Yii::t('app', 'Geom'),
            'flags' =>  Yii::t('app', 'Filters'),
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
        return $this->hasMany(AmbassadorTranslation::className(), ['event_id' => 'id']);
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
     * Gets query for [[EventTranslations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventTranslations()
    {
        return $this->hasMany(EventTranslation::className(), ['event_id' => 'id']);
    }
    
    public function getLabel()
    {
    	$html = $this->getFlagLabel(Yii::t('app', 'Events'));
    	
    	if (isset($this->content->heritage))
    		$html .= '<br /><em>'. $this->content->heritage->short_name .'</em>';
    		
    	return $html;
    }
    
    public function getEventRoute()
    {    	
		if ($geometry = SwissGeometryBehavior::toGeometry($this->type, $this->geom))
		{
			return Route::find()
    			->joinWith('content')
    			->where('ST_DWithin(geom, '. $geometry .', '. \Yii::$app->params['routeEventBuffer'] .')')
    			->andWhere(['published' => true, 'hidden' => false, 'archive' => false, 'approved' => true])
    			->one();
    	}
    	return false;
    }
}
