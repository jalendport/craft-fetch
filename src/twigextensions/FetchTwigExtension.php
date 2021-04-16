<?php
/**
 * Fetch plugin for Craft CMS 3.x
 *
 * Utilise the Guzzle HTTP client from within your Craft templates.
 *
 * @link      https://github.com/jalendport
 * @copyright Copyright (c) 2018 Jalen Davenport
 */

namespace jalendport\fetch\twigextensions;

use jalendport\fetch\Fetch;

use Craft;

/**
* @author    Jalen Davenport
* @package   Fetch
* @since     1.1.0
*/
class FetchTwigExtension extends \Twig_Extension
{
  public function getName()
  {
      return 'Fetch';
  }

  public function getFunctions()
  {
      return [
          new \Twig_SimpleFunction('fetch', [$this, 'fetch']),
      ];
  }

  public function fetch($client, $method, $destination = '', $request = [], $parseJson = true)
  {
      $client = new \GuzzleHttp\Client($client);
    /**
     * @note Why check `null` then re-assign param?
     * In Guzzle 7 if the relative URI param aka $destination is `null || undefined`
     * an error of 'URI must be a string or UriInterface' will be thrown.
     * @see https://github.com/jalendport/craft-fetch/issues/9
     */
    if (is_null($destination)) $destination = '';

      try {

        $response = $client->request($method, $destination, $request);

        if ($parseJson) {
            $body = json_decode($response->getBody(), true);
        } else {
            $body = (string)$response->getBody();
        }

        return [
          'statusCode' => $response->getStatusCode(),
          'reason' => $response->getReasonPhrase(),
          'body' => $body
        ];

      } catch (\Exception $e) {

        return [
          'error' => true,
          'reason' => $e->getMessage()
        ];

      }
  }
}
