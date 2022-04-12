# REST API Documentation

### POI
[GET poi/list](#get-poi-list)  
[GET poi/:id](#get-poi) 

### Route

[GET route/list](#get-route-list)  
[GET route/:id](#get-route) 


## <a name="get-poi-list"></a>GET poi/list

### Example Request

```
curl https://api.ourheritage.ch/v1/poi/list
```

### Example Response
```
{
    "type": "FeatureCollection",
    "features": [
        {
            "type": "Feature",
            "properties": {
                "id": 17,
                "label": "Interessanter Ort<br \/><em>Swiss Alps Jungfrau-Aletsch<\/em>",
                "title": "Suone Stigwasser"
            },
            "geometry": {
                "type": "Point",
                "coordinates": [
                    638720,
                    158338
                ]
            }
        },
        {
            "type": "Feature",
            "properties": {
                "id": 21,
                "label": "Geführte Besichtigung<br \/><em>Tektonikarena Sardona<\/em>",
                "title": "Geo-Stadtspaziergang Glarus "
            },
            "geometry": {
                "type": "Point",
                "coordinates": [
                    671704,
                    145775
                ]
            }
        }
    ]
}
```

## <a name="get-poi"></a>GET poi/:id

### Parameters

| Parameter    |Type     |Description                     |              |
|--------------|:-------:|:------------------------------:|:------------:|
| id           |integer  |ID of the requested POI         |Required      |
| lang         |string   |Language code (de, fr, it, en)  |Optional      |

### Example Request

```
curl https://api.ourheritage.ch/v1/poi/17?lang=de
```

### Example Response
```
{
    "id": 17,
    "slug": "suone-stigwasser",
    "label": "Interessanter Ort<br \/><em>Swiss Alps Jungfrau-Aletsch<\/em>",
    "title": "Suone Stigwasser",
    "description": "<p>Das Stigwasser ist die zweitunterste von insgesamt vier Suonen, welche einst aus dem Gredetschtal auf die Munderseite gef&uuml;hrt wurden. Die Spuren dieser vier Suonen sind von der linken Talseite aus noch sehr deutlich erkennbar. Erstmals urkundlich erw&auml;hnt wird das 3.6 km lange Stigwasser in einem Reglement von 1521. Die zum Teil durch spektakul&auml;res Gel&auml;nde und steile Felsabschnitte f&uuml;hrende Suone leitet das Wasser des Mundbaches heute praktisch nur noch zu touristischen Zwecken nach Mund, weshalb sie in niederschlagsarmen Zeiten oftmals trocken liegt.<\/p>\r\n\r\n<p>&nbsp;<\/p>\r\n"
}
```

## <a name="get-route-list"></a>GET route/list

### Example Request

```
curl https://api.ourheritage.ch/v1/route/list
```

### Example Response
```
```

## <a name="get-route"></a>GET route/:id

### Parameters

| Parameter    |Type     |Description                     |              |
|--------------|:-------:|:------------------------------:|:------------:|
| id           |integer  |ID of the requested route       |Required      |
| lang         |string   |Language code (de, fr, it, en)  |Optional      |

### Example Request

```
curl https://api.ourheritage.ch/v1/route/10?lang=de
```

### Example Response
```

```