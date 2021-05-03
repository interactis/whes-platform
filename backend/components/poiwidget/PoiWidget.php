<?php

namespace backend\components\poiwidget;

use Yii;
use yii\db\Expression;
use yii\widgets\InputWidget;
use common\models\Poi;

class PoiWidget extends InputWidget
{

    private $assetBundle;
    public $value = '';
    public $created = false;

    public function init()
    {
        parent::init();
        $this->registerAssetBundle();
    }

    public function run()
    {
        return $this->render('map', $this->getOptions());
    }

    /**
     * Set options for rendering the view.
     *
     * @return array
     */
    private function getOptions() {
        $geom = $this->getGeom();
        return array(
            'latitude' => $geom['latitude'],
            'longitude' => $geom['longitude'],
            'model' => $this->model,
            'attribute' => $this->attribute,
            'value' => ($this->created) ? '645500,150000' : sprintf('%s,%s', $geom['latitude'], $geom['longitude']),
            'created' => $this->created,
            'markerImgUrl' => sprintf('%s/%s', $this->assetBundle->baseUrl, 'images/locate.png'),
            'pinImgUrl' => sprintf('%s/%s', $this->assetBundle->baseUrl, 'images/pin.png'),
            'baseUrl' => $this->assetBundle->baseUrl,
        );
    }

    /**
     * Extract latitude and longitude from value string.
     */
    public function getGeom() {
        if (!$this->created) {
            // edge case (causing a bug):
            // when the backend poi-edit form is submitted with errors in the translations, $this->value contains
            // the db expression and not the actual value.
            // but: the db-expression string is formatted 'wrong', so we need to resolve the value again. this
            // is a workaround, but at least fixes the bug.
            // directly fetching the db expression results in an sql error
            // the 'original' value is not available on '$this'
            if ($this->value instanceof Expression) {
                $geom = Poi::findOne($this->model->id)->geom;
                $latitude = $geom[0];
                $longitude = $geom[1];
            } else {
                $latitude = $this->value[0];
                $longitude = $this->value[1];
            }
            
        } else {  // Default coordinates: aletschgletscher.
            $latitude = 645500;
            $longitude = 150000;
        }
        return array('latitude' => $latitude, 'longitude' => $longitude);
    }

    /**
     * Registers the asset bundle and locale
     */
    public function registerAssetBundle()
    {
        $view = $this->getView();
        $this->assetBundle = PoiAsset::register($view);
    }
}