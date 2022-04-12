# REST API Documentation

### Phrase
[GET phrase/list](#get-phrase-list)  
[GET phrase](#get-phrase) 

### Pages

[GET page/:slug](#get-page)  

### Meta

[GET meta/perimeter](#get-meta-perimeter)  


## <a name="get-phrase-list"></a>GET phrase/list

### Example Request

```
curl https://dialekt-api.jungfraualetsch.ch/v1/pharse/list
```

### Example Response
```
[
    {
        "id": 4,
        "title": "Gut"
    },
    {
        "id": 3,
        "title": "Es hat geschneit"
    },
    {
        "id": 3,
        "title": "Ein gutes neues Jahr"
    }
]
```

## <a name="get-phrase"></a>GET phrase/:id

### Parameters

| Parameter    |Type     |Description                     |              |
|--------------|:-------:|:------------------------------:|:------------:|
| id           |string   |ID of the requested phrase      |Required      |

### Example Request

```
curl https://dialekt-api.jungfraualetsch.ch/v1/pharse/3
```

### Example Response
```

```

## <a name="get-page"></a>GET page/:slug

### Parameters

| Parameter    |Type     |Description                                     |              |
|--------------|:-------:|:----------------------------------------------:|:------------:|
| slug         |string   |`instructions`, `glossary`, `about` or `terms`  |Required      |

### Example Request

```
curl --request POST -d "lang=de" https://dialekt-api.jungfraualetsch.ch/v1/page/glossary
```

### Example Response
```
{
	"id": 1,
	"title": "Glossar",
	"content": "<p>HTML content<\/p>"
}

## <a name="get-meta-perimeter"></a>GET meta/perimeter


### Example Request

```
curl --request https://dialekt-api.jungfraualetsch.ch/v1/meta/perimeter
```

### Example Response
```
{
	"type": "FeatureCollection",
	"name": "Welterbe-Perimeter",
	"crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:EPSG::21781" } },
	"features": [...]
}
```