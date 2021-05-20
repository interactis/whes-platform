<?php

use Yii\web\View;

$js = "var mapWmsUrl = '". Yii::$app->params['mapWmsUrl'] ."'";
$this->registerJs($js, $this::POS_HEAD);
?>

<div id="bg-map" class="map-full" 
     data-poi-url="<?= $poiImgUrl ?>"
     data-poi-highlight-url="<?= $poiHighlightImgUrl ?>"
     data-disabled-poi-url="<?= $disabledPoiImgUrl ?>"
     data-disabled-poi-highlight-url="<?= $highlightDisabledPoi ?>"
     data-location-url="<?= $locationImgUrl ?>"
     data-cluster-url="<?= $clusterImgUrl ?>"
     data-ambassador-url="<?= $ambassadorImgUrl ?>"
     data-disabled-ambassador-url="<?= $disabledAmbassadorImgUrl ?>"
     data-ambassador-highlight-url="<?= $ambassadorHighlightImgUrl ?>"
     data-disabled-ambassador-highlight-url="<?= $highlightDisabledAmbassador ?>"></div>

<div class="map-controls">
    
    <?php
    /*
    <div>
        <a class="btn btn-default btn-sm search" data-toggle="modal" data-target="#where-to-go-modal">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
        </a>
    </div>
    */
    ?>
    
    <?php
    /*
    <div>
        <a class="btn btn-default btn-sm locate-me" title="<?= Yii::t('app', 'Meinen Standort anzeigen') ?>">
        	<i class="fa fa-map-marker"></i>
        </a>
    </div>
    */
    ?>
    
    <div class="zoom btn-group-vertical"></div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="location-disabled">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= Yii::t('app', 'Standortabfrage fehlgeschlagen') ?></h4>
            </div>
            <div class="modal-body">
                <p><?= Yii::t('app', 'Bitte erlauben Sie den Zugriff auf Ihren Standort, um diesen hier anzuzeigen.') ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Close') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="map-settings">
	<div class="margin-bottom">
		<h4 class="margin-bottom-sm"><?= Yii::t('app', 'Display'); ?></h4>
		<ul class="list-unstyled">
			<li class="toggle-hike">
				<input type="checkbox" id="hike-layer">&nbsp;
				<label for="hike-layer"><?= Yii::t('app', 'Hiking Trail Network'); ?></label>
			</li>
			<li class="toggle-perimeter">
				<input type="checkbox" checked="checked" id="perimeter-layer">&nbsp;
				<label for="perimeter-layer"><?= Yii::t('app', 'World Heritages'); ?></label>
			</li>
		</ul>
	</div>
	<div>
		<h4 class="margin-bottom-sm"><?= Yii::t('app', 'View'); ?></h4>
		<div id="layer-slider">
			<span class="label ui-slider-inner-label" style="left: 0px; top: 24px;">Ortho</span>
			<div class="ui-slider-handle"></div>
			<span class="label ui-slider-inner-label" style="right:0px; top: 24px;">Topo</span>
		</div>
	</div>
	<div class="sidebar-handle">
		<i class="fa fa-chevron-left"></i>
	</div>
</div>

<!-- Modal «Wo soll es hingehen?» -->
<div class="modal fade" id="where-to-go-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
