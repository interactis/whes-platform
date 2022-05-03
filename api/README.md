# REST API Documentation

### POI
[GET poi/list](#get-poi-list)  
[GET poi/:id](#get-poi) 

### Route

[GET route/list](#get-route-list)  
[GET route/:id](#get-route) 

### Heritage

[GET heritage/list](#get-heritage-list)  
[GET heritage/perimeter](#get-heritage-perimeter)  
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
                "type": 'poi',
                "marker": "https:\/\/ourheritage.ch\/img\/layout\/poi-marker.svg",
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
                "type": 'poi',
                "marker": "https:\/\/ourheritage.ch\/img\/layout\/poi-marker.svg",
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
    "type": "poi",
    "slug": "suone-stigwasser",
    "label": "Interessanter Ort<br \/><em>Swiss Alps Jungfrau-Aletsch<\/em>",
    "title": "Suone Stigwasser",
    "description": "<p>Lorem ipsum dolor ...<\/p>",
    "img": {
        "url": "http:\/\/ourheritage.ch\/img\/layout\/placeholder\/600\/placeholder.jpg",
        "alt": ""
    }
}
```

## <a name="get-route-list"></a>GET route/list

### Parameters

| Parameter    |Type     |Description                                                   |              |
|--------------|:-------:|:------------------------------------------------------------:|:------------:|
| type         |string   |"general" (e.g. Grand Tours) or "detail" (heritage routes)    |Required      |

### Example Request

```
curl https://api.ourheritage.ch/v1/route/list?type=detail
```

### Example Response
```
{
    "type": "FeatureCollection",
    "features": [
        {
            "type": "Feature",
            "properties": {
                "id": 10,
                "type": 'route',
                "title": "Am Fusse des Eigers"
            },
            "geometry": {
                "type": "LineString",
                "coordinates": [
                    [
                        645472.004451798,
                        178811.195983901
                    ],
                    [
                        653139.268639388,
                        177203.646654112
                    ],
                    [
                        668481.60497933,
                        158194.35391896
                    ],
                    [
                        668423.88750327,
                        158166.12636386
                    ],
                    [
                        668417.01253547,
                        158177.38782045
                    ],
                    [
                        668399.8842279,
                        158166.63164582
                    ],
                    [
                        668393.83149767,
                        158173.01086773
                    ]
                ]
            }
        },
        {
            "type": "Feature",
            "properties": {
                "id": 11,
                "type": 'route',
                "label": "Wanderung<br \/><em>Swiss Alps Jungfrau-Aletsch<\/em>",
                "title": "Auf den Pfaden der Bergbauern"
            },
            "geometry": {
                "type": "LineString",
                "coordinates": [
                    [
                        645472.004451798,
                        178811.195983901
                    ],
                    [
                        653139.268639388,
                        177203.646654112
                    ],
                    [
                        668481.60497933,
                        158194.35391896
                    ],
                    [
                        668423.88750327,
                        158166.12636386
                    ],
                    [
                        668417.01253547,
                        158177.38782045
                    ],
                    [
                        668399.8842279,
                        158166.63164582
                    ],
                    [
                        668393.83149767,
                        158173.01086773
                    ]
                ]
            }
        }
    ]
}
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
{
    "id": 10,
    "type": "route",
    "slug": "am-fusse-des-eigers",
    "label": "Wanderung<br \/><em>Swiss Alps Jungfrau-Aletsch<\/em>",
    "title": "Am Fusse des Eigers"
    "description": "<p>Lorem ipsum dolor ...<\/p>",
    "img": {
        "url": "http:\/\/ourheritage.ch\/img\/layout\/placeholder\/600\/placeholder.jpg",
        "alt": ""
    }
}
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
                "type": 'heritage',
                "marker": "https:\/\/ourheritage.ch\/img\/heritage\/badge\/5.svg",
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
                "type": 'heritage',
                "marker": "https:\/\/ourheritage.ch\/img\/heritage\/badge\/8.svg",
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

## <a name="get-heritage-perimeter"></a>GET heritage/perimeter

### Example Request

```
curl https://api.ourheritage.ch/v1/heritage/perimeter
```

### Example Response
```
{
    "type": "FeatureCollection",
    "features": [
        {
            "type": "Feature",
            "properties": {
                "id": 5
            },
            "geometry": {
                "type": "MultiPolygon",
                "coordinates": [
                    [
                        [
                            [
                                656937.999958435,
                                170139.999994016
                            ],
                            [
                                656964.999973268,
                                170117.999999414
                            ],
                            [
                                656985.000033712,
                                170095.000028125
                            ],
                            
                            ...
                    	
                    	]
                    ]
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
    "type": "heritage",
    "slug": "swiss-alps-jungfrau-aletsch",
    "label": "UNESCO-Welterbe",
    "title": "Schweizer Alpen Jungfrau-Aletsch",
    "description": "<p>Lorem ipsum dolor ...<\/p>",
    "img": {
        "url": "http:\/\/ourheritage.ch\/img\/layout\/placeholder\/600\/placeholder.jpg",
        "alt": ""
    }
}
```
