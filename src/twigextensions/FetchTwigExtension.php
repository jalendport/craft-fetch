<?php
/**
 * Fetch plugin for Craft CMS 4.x
 *
 * Utilise the Guzzle HTTP client from within your Craft templates.
 *
 * @link      https://github.com/jalendport
 * @copyright Copyright (c) 2018 Jalen Davenport
 */

namespace jalendport\fetch\twigextensions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @author    Jalen Davenport
 * @package   Fetch
 * @since     1.1.0
 */
class FetchTwigExtension extends AbstractExtension
{
	public function getName(): string
	{
		return 'Fetch';
	}

	public function getFunctions(): array
	{
		return [
			new TwigFunction('fetch', [$this, 'fetch']),
		];
	}

	public function fetch($client, $method, $destination, $request = [], $parseJson = true): array
	{
		$client = new Client($client);

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

		} catch (GuzzleException $e) {

			return [
				'error' => true,
				'reason' => $e->getMessage()
			];

		}
	}
}
