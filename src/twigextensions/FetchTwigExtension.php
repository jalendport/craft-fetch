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

  public function fetch($client, $method, $destination, $request = [], $format = 'json')
  {
      $client = new \GuzzleHttp\Client($client);

      try {

        $response = $client->request($method, $destination, $request);

        if ($format == 'json') {
            $body = json_decode($response->getBody(), true);
        } elseif ($format == 'xml') {
            $xmlbody = simplexml_load_string($response->getBody(), null, LIBXML_NOCDATA);

            $json = json_encode($xmlbody);
            $body = json_decode($json, true);
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