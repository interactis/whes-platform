<?php

namespace common\models;

use Yii;
use common\components\elasticsearch\SajaClientBuilder;
use nanson\postgis\behaviors\GeometryBehavior;
use Elasticsearch\Common\Exceptions\Missing404Exception;

/**
 * This is the model class for table "SwissnamesSaja".
 *
 * @property integer $gid
 * @property double $objectid
 * @property string $objectorig
 * @property string $objectval
 * @property double $yearofchan
 * @property string $name
 * @property double $gemnr
 * @property string $gemname
 * @property string $kanton
 * @property string $altitude
 * @property string $the_geom
 */
class SwissnamesSaja extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SwissnamesSaja';
    }

    /**
     * geom is a postgis field; treat it as a 'point'.
     */
    public function behaviors()
    {
        return [
            [
                'class' => GeometryBehavior::className(),
                'type' => GeometryBehavior::GEOMETRY_POINT,
                'attribute' => 'the_geom',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['objectid', 'yearofchan', 'gemnr', 'altitude'], 'number'],
            [['the_geom'], 'string'],
            [['objectorig'], 'string', 'max' => 20],
            [['objectval'], 'string', 'max' => 12],
            [['name'], 'string', 'max' => 60],
            [['gemname'], 'string', 'max' => 50],
            [['kanton'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gid' => Yii::t('app', 'Gid'),
            'objectid' => Yii::t('app', 'Objectid'),
            'objectorig' => Yii::t('app', 'Objectorig'),
            'objectval' => Yii::t('app', 'Objectval'),
            'yearofchan' => Yii::t('app', 'Yearofchan'),
            'name' => Yii::t('app', 'Name'),
            'gemnr' => Yii::t('app', 'Gemnr'),
            'gemname' => Yii::t('app', 'Gemname'),
            'kanton' => Yii::t('app', 'Kanton'),
            'altitude' => Yii::t('app', 'Altitude'),
            'the_geom' => Yii::t('app', 'The Geom'),
        ];
    }

    /**
     * @return array
     * Simple mapping for desired values in the ES index.
     * 'objectval' sometimes starts with two capital letters (e.g. KBach, KGipfel). If this is the case, strip the first
     * capital letter.
     */
    public function getElasticSearchMapping()
    {
        return [
            'id' => $this->objectid,
            'name' => sprintf('%s (%s)', $this->name, $this->kanton),
            'gemname' => $this->gemname,
            'objectval' => (ctype_upper(substr($this->objectval, 0, 2))) ? substr($this->objectval, 1) : $this->objectval,
            'geom' => $this->the_geom,
        ];
    }

    /**
     * Search elasticsearch-index for swissnames with a param 'q'
     *
     * @param $query
     * @return array
     */
    public static function searchElasticSearchIndex($query)
    {
        $client = SajaClientBuilder::create()->build();
        return $client->search([
            'index' => strtolower(self::tableName()),
            'q' => sprintf('name:%s*', str_replace(['(', ')'], '', $query)),
            'default_operator' => 'AND',
            'sort' => array('objectval:asc', 'name:asc'),
            'size' => 100
        ]);
    }

    /**
     * Get single element by ID from elasticsearch-index for swissnames
     *
     * @param $id
     * @return array
     */
    public static function getElasticSearchIndex($id)
    {
        $client = SajaClientBuilder::create()->build();
        try {
            return $client->get([
                'index' => strtolower(self::tableName()),
                'id' => $id,
                'type' => strtolower(self::tableName())
            ]);
        } catch (Missing404Exception $e) {
            return [];
        }
    }

    /**
     * Use this with the command line script
     */
    static function updateESIndex()
    {
        $client = SajaClientBuilder::create()->build();
        // partial update would be nicer. but as this will rarely change, just delete the whole index before re-indexing
        // the documents.
        $params = ['index' => strtolower(self::tableName())];
        try {
            $client->indices()->delete($params);
        } catch (Missing404Exception $e) {
             // The index doesn't exist - so no need to remove it.
        }

        foreach(SwissnamesSaja::find()->all() as $element) {
            $params = [
                'index' => strtolower(self::tableName()),
                'type' => strtolower(self::tableName()),
                'id' => $element->gid,
                'body' => $element->getElasticSearchMapping()
            ];
            $client->create($params);
        }
    }
}
