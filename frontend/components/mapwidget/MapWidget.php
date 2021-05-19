<?php

namespace frontend\components\mapwidget;

use Yii;
use yii\base\Widget;


/**
 * Class MapWidget
 * @package common\components
 *
 */
class MapWidget extends Widget
{

    private $assetBundle;

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

        return array(
            'baseUrl' => $this->assetBundle->baseUrl,
            'poiImgUrl' => sprintf('%s/images/marker.png', $this->assetBundle->baseUrl),
            'disabledPoiImgUrl' => sprintf('%s/images/marker_disabled.png', $this->assetBundle->baseUrl),
            'poiHighlightImgUrl' => sprintf('%s/images/highlight.png', $this->assetBundle->baseUrl),
            'highlightDisabledPoi' => sprintf('%s/images/highlight_disabled.png', $this->assetBundle->baseUrl),
            'clusterImgUrl' => sprintf('%s/images/cluster.png', $this->assetBundle->baseUrl),
            'locationImgUrl' => sprintf('%s/images/location.png', $this->assetBundle->baseUrl),
            'ambassadorImgUrl' => sprintf('%s/images/ambassador.png', $this->assetBundle->baseUrl),
            'disabledAmbassadorImgUrl' => sprintf('%s/images/ambassador_disabled.png', $this->assetBundle->baseUrl),
            'ambassadorHighlightImgUrl' => sprintf('%s/images/highlight_ambassador.png', $this->assetBundle->baseUrl),
            'highlightDisabledAmbassador' => sprintf('%s/images/highlight_ambassador_disabled.png', $this->assetBundle->baseUrl),
        );
    }
    /**
     * Registers the asset bundle and locale
     */
    public function registerAssetBundle()
    {
        $view = $this->getView();
        $this->assetBundle = MapAsset::register($view);
    }
}
