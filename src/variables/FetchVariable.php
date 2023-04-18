<?php
/**
 * Fetch plugin for Craft 4
 *
 * Guzzle HTTP client from within your Craft templates.
 *
 * @link      https://github.com/jalendport
 * @copyright Copyright (c) 2018 Jalen Davenport
 */

namespace jalendport\fetch\variables;

use Craft;
use GuzzleHttp\Exception\GuzzleException;
use craft\helpers\Json;

/**
 * @author    Jalen Davenport
 * @package   Fetch
 * @since     1.0.0
 */
class FetchVariable
{
    // Public Methods
    // =========================================================================

    /**
     * @param $client
     * @param $method
     * @param $destination
     * @param array $request
     * @return array|string
     */
    public function request($client, $method, $destination, array $request = []): array|string
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

        if (Json::isJsonObject($result->getBody())) {
            $body = Json::decode($result->getBody());
        } else {
            $body = (string)$result->getBody();
        }

        return [
            'statusCode' => $result->getStatusCode(),
            'reason' => $result->getReasonPhrase(),
            'body' => $body
        ];
    }
}
