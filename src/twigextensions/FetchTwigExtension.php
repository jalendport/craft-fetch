<?php
/**
 * Fetch plugin for Craft 4
 *
 * Guzzle HTTP client from within your Craft templates.
 *
 * @link      https://github.com/jalendport
 * @copyright Copyright (c) 2018 Jalen Davenport
 */

namespace jalendport\fetch\twigextensions;

use Craft;
use GuzzleHttp\Exception\GuzzleException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use craft\helpers\Json;

/**
 * @author    Jalen Davenport
 * @package   Fetch
 * @since     1.1.0
 */
class FetchTwigExtension extends AbstractExtension
{
    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('fetch', [$this, 'fetch']),
        ];
    }

    /**
     * @param $client
     * @param $method
     * @param $destination
     * @param array $request
     * @param bool $parseJson
     * @return array
     */
    public function fetch($client, $method, $destination, array $request = [], bool $parseJson = true): array
    {
        $client = Craft::createGuzzleClient($client);

        try {
            $result = $client->request($method, $destination, $request);
        } catch (GuzzleException $e) {
            Craft::error($e->getMessage(), __METHOD__);
            return [
                'error' => true,
                'reason' => $e->getMessage()
            ];
        }

        $body = '';

        if (Json::isJsonObject($result->getBody())) {
            $body = Json::decode($result->getBody());
        }

        if (!$parseJson) {
            $body = (string)$result->getBody();
        }

        return [
            'statusCode' => $result->getStatusCode(),
            'reason' => $result->getReasonPhrase(),
            'body' => $body
        ];
    }
}
