<img src="src/icon.svg" alt="icon" width="100" height="100">

# Fetch plugin for Craft 4

Guzzle HTTP client from within your Craft templates

## Requirements

This plugin is compatible with Craft 4 and up.

### Parameters

| Parameter | Example value |
| --------- | ------------- |
| `client`  | `{ base_uri : 'https://gtmetrix.com', timeout : 10 } ` |
| `method`  | `'POST'` |
| `destination` | `'api/0.1/test'` |
| `options` | `{ auth : ['username', 'password'] }` |

### Example Usage

#### Request

```twig
{% set client = {
    base_uri : 'https://official-joke-api.appspot.com/',
    timeout : 10
} %}

{% set options = {} %}

{% set request = fetch(client, 'GET', 'random_joke', options) %}

{% dd(request|json_encode|raw) %}
```

#### Response (successful)

```json
{
  "statusCode": 200,
  "reason": "OK",
  "body": {
    "type": "general",
    "setup": "Who is the coolest Doctor in the hospital?",
    "punchline": "The hip Doctor!",
    "id": 302
  }
}
```

You can fetch the string response by adding an additional parameter of `false` like so:

```twig
{% set client = {
    base_uri : 'http://api.geonames.org/'
} %}

{% set request = fetch(client, 'GET', 'srtm1?lat=50.01&lng=10.2&username=demo&style=full', {}, false) %}

{% dd(request|raw) %}
```

#### Response (error)

```json
{
  "statusCode": 200,
  "reason": "200",
  "body": "208"
}
```

## Fetch Roadmap

Some things to do, and ideas for potential features:

Brought to you by [Luke Youell](https://github.com/lukeyouell)
