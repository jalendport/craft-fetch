<?php
/**
 * Fetch plugin for Craft CMS 3.x
 *
 * Utilise the Guzzle HTTP client from within your Craft templates.
 *
 * @link      https://github.com/lukeyouell
 * @copyright Copyright (c) 2018 Luke Youell
 */

namespace lukeyouell\fetch\twigextensions;

use lukeyouell\fetch\Fetch;

use Craft;

/**
* @author    Luke Youell
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

  public function fetch($client, $method, $destination, $request = [], $parseJson = true)
  {
      $client = new \GuzzleHttp\Client($client);

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
