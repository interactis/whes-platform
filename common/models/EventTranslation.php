<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "event_translation".
 *
 * @property int $id
 * @property int|null $event_id
 * @property int|null $language_id
 * @property string|null $slug
 * @property string|null $title
 * @property string|null $description
 * @property string|null $schedule
 * @property string|null $youtube_id
 * @property string|null $vimeo_id
 * @property string|null $directions
 * @property string|null $remarks
 * @property string|null $ticket_title
 * @property string|null $ticket_button_url
 * @property string|null $ticket_button_text
 * @property string|null $ticket_remarks
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Language $language
 * @property Event $event
 */
class EventTranslation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_translation';
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'language_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['event_id', 'language_id', 'created_at', 'updated_at'], 'integer'],
            [['description', 'schedule', 'directions', 'remarks'], 'string'],
            [['slug', 'title', 'youtube_id', 'vimeo_id', 'ticket_title', 'ticket_button_url', 'ticket_button_text'], 'string', 'max' => 255],
            [['ticket_remarks'], 'string', 'max' => 180],
            [['ticket_button_url'], 'url'],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['event_id' => 'id']],
            [['slug'], 'match', 'pattern' => '/^[a-z][-a-z0-9]*$/', 'message' => Yii::t('app', 'Slug can contain only small letters, numbers and -')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'event_id' => Yii::t('app', 'Event ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'slug' => Yii::t('app', 'Slug'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'schedule' => Yii::t('app', 'Programme / Agenda'),
            'youtube_id' => Yii::t('app', 'YouTube ID'),
            'vimeo_id' => Yii::t('app', 'Vimeo ID'),
            'directions' => Yii::t('app', 'Direction Instructions (optional)'),
            'remarks' => Yii::t('app', 'Remarks'),
            'ticket_title' => Yii::t('app', 'Ticket Title'),
            'ticket_button_url' => Yii::t('app', 'Ticket Button URL'),
            'ticket_button_text' => Yii::t('app', 'Ticket Button Text'),
            'ticket_remarks' => Yii::t('app', 'Ticket Remarks'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * Gets query for [[Event]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }
}
