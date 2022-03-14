<?php
namespace common\models;

use common\components\SwissGeometryBehavior;


/**
 * Class ConvertedAmbassador
 * @package common\models
 *
 * Poi with 'automagic' conversion of the geom-field. Arrays can be used in the php code, values are converted when
 * interacting with the database.
 */
class ConvertedAmbassador extends Ambassador
{
    /**
     * geom is a postgis field; treat it as a 'point'.
     */
    public function behaviors()
    {
        return [
            [
                'class' => SwissGeometryBehavior::className(),
                'type' => SwissGeometryBehavior::GEOMETRY_POINT,
                'attribute' => 'geom',
            ],
        ];
    }   
}
?>
