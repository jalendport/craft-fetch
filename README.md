> [!WARNING] 
> This plugin has been abandoned.

---

<img src="src/icon.svg" alt="icon" width="100" height="100">

# Fetch plugin for Craft CMS

## Why this plugin is retired

Fetch made synchronous, uncached HTTP requests during Twig rendering. That was a convenient shortcut in 2018, but it's now a well-documented performance anti-pattern: every page render blocks on the external API, and if that API slows down or goes down, so does your site. Craft can also now do everything this plugin did natively, with no plugin installed.

## Migrating away from Fetch

### Option 1: Native Twig (direct replacement)

Guzzle ships with Craft, and Craft's `create()` Twig function can instantiate it — no plugin required. This is a drop-in replacement for what Fetch did:

    {% set client = create('GuzzleHttp\\Client') %}

    {% set response = client.request('GET', 'https://api.example.com/endpoint', {
        timeout: 5,
        http_errors: false,
    }) %}

    {% if response.getStatusCode() == 200 %}
        {% set data = response.getBody().getContents() | json_decode %}
    {% endif %}

Note that this has the same drawback Fetch had: it blocks the render. If you use it, wrap the output in a [`{% cache %}` tag](https://craftcms.com/docs/5.x/reference/twig/tags.html#cache) at minimum.

### Option 2: Do it properly (recommended for production)

- **Server-side data:** fetch in a [custom module/service](https://craftcms.com/docs/5.x/extend/services.html) and cache the result, keeping HTTP out of the render path entirely.
- **Async partials:** use [Sprig](https://putyourlightson.com/plugins/sprig) or htmx to load API-driven fragments after first paint.
- **Non-critical or personalized data:** fetch client-side in JavaScript.

### Option 3: Maintained plugin alternatives

- [**Consume** by Verbb](https://plugins.craftcms.com/consume) — commercial; built-in caching, OAuth/credential management in the control panel, JSON/XML/CSV/HTML parsing.
- [**Simple Guzzle**](https://plugins.craftcms.com/simple-guzzle) — free; template-level requests with caching.

## Thanks

Thanks to [Luke Youell](https://github.com/lukeyouell) for creating this plugin, and to everyone who used and contributed to it over the years.
