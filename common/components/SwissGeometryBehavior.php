<?php
namespace common\components;

use yii\db\Expression;
use nanson\postgis\behaviors\GeometryBehavior;
use nanson\postgis\helpers\GeoJsonHelper;

/**
* The package in use has no config/variable for the used coordinates. Override the relevant method with swiss
* projection.
*/
class SwissGeometryBehavior extends GeometryBehavior
{
	public function afterFind()
    {
		if ($this->owner->{$this->attribute})
		{
			if (!is_object(json_decode($this->owner->{$this->attribute})))
			{
				if ($this->skipAfterFindPostgis)
				{
					return true;
				}
				else
				{
					$this->postgisToGeoJson();
				}
			}
		}
        $this->geoJsonToCoordinates();
        $this->owner->setOldAttribute($this->attribute, $this->owner->{$this->attribute});
        return true;
    }
    
	public static function toGeometry($type, $coordinates)
	{
		if (!empty($coordinates))
		{
			return GeoJsonHelper::toGeometry($type, $coordinates, '21781');
		}
		else
			return false;
	}

    protected function coordinatesToGeoJson()
    {
        $coordinates = $this->owner->{$this->attribute};
        
        if (!empty($coordinates))
        {
            $query = is_array($coordinates) ? GeoJsonHelper::toGeometry($this->type, $coordinates, '21781') : "'$coordinates'";
            $this->owner->{$this->attribute} = new Expression($query);
        }
        else
        {
            $this->owner->{$this->attribute} = null;
        }
    }
}