<?php

use yii\helpers\Url;
?>

<div id="map">
    <div id="search">
        <a title="Suchen auf Karte" id="search-button"></a>
        <div id="search-outer">
            <div class="map-control-inner-div" style="cursor: default;">
                <label for="whereto">Search:</label>
                <input type="text" id="whereto" class="ui-autocomplete-input" autocomplete="off"><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
            </div>
        </div>
    </div>
    <div id="slider-id">
        <div class="ui-slider-handle"></div>
    </div>
    <div id="popup"></div>
</div>
<input type="hidden" id="<?= strtolower($model::tableName()) ?>-<?= $attribute ?>" class="form-control"
       name="<?= ucfirst($model::tableName()) ?>[<?= $attribute ?>]" value="<?= $value ?>" >
<div class="help-block"></div>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function (event) {
        $('#map').setPoiMap({
            latitude: parseInt("<?= $latitude ?>"),
            longitude: parseInt("<?= $longitude ?>"),
            inputField: "<?= strtolower($model::tableName()) ?>-<?= $attribute ?>",
            iconImgSrc: "<?= $pinImgUrl ?>",
            searchUrl: "<?= Url::toRoute(['poi/search']) ?>"
        });
    });
</script>
