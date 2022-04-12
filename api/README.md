# REST API Documentation

### POI
[GET poi/list](#get-poi-list)  
[GET poi](#get-poi) 

### Route

[GET route/list](#get-route-list)  
[GET route](#get-route) 


## <a name="get-poi-list"></a>GET poi/list

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
curl https://api.ourheritage.ch/v1/poi/12?lang=de
```

### Example Response
```

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