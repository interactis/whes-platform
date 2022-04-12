# REST API Documentation

### POI
[GET poi/list](#get-poi-list)  
[GET poi](#get-poi) 

### Route

[GET route/list](#get-route-list)  
[GET route](#get-route) 


## <a name="get-phrase-list"></a>GET poi/list

### Example Request

```
curl https://api.ourheritage.ch/v1/poi/list
```

### Example Response
```
```

## <a name="get-poi"></a>GET poi/:id

### Parameters

| Parameter    |Type     |Description                     |              |
|--------------|:-------:|:------------------------------:|:------------:|
| id           |integer  |ID of the requested POI         |Required      |
| lang         |string   |Language code (de, fr, it, en)  |Optional      |

### Example Request

```
curl https://api.ourheritage.ch/v1/poi/7?lang=de
```

### Example Response
```

```
