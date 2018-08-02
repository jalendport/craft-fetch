<img src="src/icon.svg" alt="icon" width="100" height="100">

# Fetch plugin for Craft CMS 3.x

Utilise the Guzzle HTTP client from within your Craft templates.

## Requirements

This plugin requires Craft CMS 3.0.0 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require lukeyouell/craft-fetch

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Fetch.

## Using Fetch

This plugin is built to work with the standard [Guzzle request options](http://docs.guzzlephp.org/en/stable/request-options.html)

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
    base_uri : 'https://gtmetrix.com',
    timeout : 10
} %}

{% set options = {
    auth : ['username', 'password'],
    form_params : {
      url : 'https://www.google.co.uk'
    }
} %}

{% set request = fetch(client, 'POST', 'api/0.1/test', options) %}
```

#### Response (successful)

```json
{
   "statusCode":200,
   "reason":"OK",
   "body": {
      "credits_left":30,
      "test_id":"JDHFbrt7",
      "poll_state_url":"https:\/\/gtmetrix.com\/api\/0.1\/test\/JDHFbrt7"
   }
}
```

You can fetch the string response by adding an additional parameter of `false` like so:

```twig
{% set request = fetch(client, 'POST', 'api/0.1/test', options, false) %}
```

#### Response (error)

```json
{
   "error":true,
   "reason":"Client error: `POST https:\/\/gtmetrix.com\/api\/0.1\/test` resulted in a `401 Authorization Required` response:\n{\u0022error\u0022:\u0022Invalid e-mail and\/or API key\u0022}\n\n"
}
```

## Fetch Roadmap

Some things to do, and ideas for potential features:

Brought to you by [Luke Youell](https://github.com/lukeyouell)
