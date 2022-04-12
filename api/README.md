# REST API Documentation

### POI
[GET poi/list](#get-poi-list)  
[GET poi/:id](#get-poi) 

### Route

[GET route/list](#get-route-list)  
[GET route/:id](#get-route) 

### Heritage

[GET heritage/list](#get-heritage-list)  
[GET heritage/:id](#get-heritage) 



## <a name="get-poi-list"></a>GET poi/list

### Parameters

| Parameter    |Type     |Description                     |              |
|--------------|:-------:|:------------------------------:|:------------:|
| lang         |string   |Language code (de, fr, it, en)  |Optional      |

### Example Request

```
curl https://api.ourheritage.ch/v1/poi/list?lang=de
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
    "description": "<p>Lorem ipsum dolor ...<\/p>"
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

## <a name="get-heritage-list"></a>GET heritage/list

### Parameters

| Parameter    |Type     |Description                     |              |
|--------------|:-------:|:------------------------------:|:------------:|
| lang         |string   |Language code (de, fr, it, en)  |Optional      |

### Example Request

```
curl https://api.ourheritage.ch/v1/heritage/list?lang=de
```

### Example Response
```
{
    "type": "FeatureCollection",
    "features": [
        {
            "type": "Feature",
            "properties": {
                "id": 5,
                "label": "UNESCO-Welterbe",
                "title": "Schweizer Alpen Jungfrau-Aletsch"
            },
            "geometry": {
                "type": "Point",
                "coordinates": [
                    648981,
                    145667
                ]
            }
        },
        {
            "type": "Feature",
            "properties": {
                "id": 8,
                "label": "UNESCO-Welterbe",
                "title": "Tektonik Arena Sardona"
            },
            "geometry": {
                "type": "Point",
                "coordinates": [
                    737808,
                    197364
                ]
            }
        }
    ]
}
```

## <a name="get-heritage"></a>GET heritage/:id

### Parameters

| Parameter    |Type     |Description                     |              |
|--------------|:-------:|:------------------------------:|:------------:|
| id           |integer  |ID of the requested heritage    |Required      |
| lang         |string   |Language code (de, fr, it, en)  |Optional      |

### Example Request

```
curl https://api.ourheritage.ch/v1/heritage/5?lang=de
```

### Example Response
```
{
    "id": 5,
    "slug": "swiss-alps-jungfrau-aletsch",
    "label": "UNESCO-Welterbe",
    "title": "Schweizer Alpen Jungfrau-Aletsch",
    "description": "<p>Lorem ipsum dolor ...<\/p>"
}
```
