<?php
/**
 * Fetch plugin for Craft CMS 4.x
 *
 * Utilise the Guzzle HTTP client from within your Craft templates.
 *
 * @link      https://github.com/jalendport
 * @copyright Copyright (c) 2018 Jalen Davenport
 */

namespace jalendport\fetch\variables;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
	 * @throws GuzzleException
	 */
	public function request($client, $method, $destination, array $request = []): array|string
	{

		$client = new Client($client);

		try {

			$response = $client->request($method, $destination, $request);

			return [
				'statusCode' => $response->getStatusCode(),
				'reason' => $response->getReasonPhrase(),
				'body' => json_decode($response->getBody(), true)
			];

		} catch (Exception $e) {

			return [
				'error' => true,
				'reason' => $e->getMessage()
			];

		}

	}

}
