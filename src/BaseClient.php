<?php

/*
 * This file is part of the Payclip PHP SDK.
 *
 * ©2025 Doqimi <developer@doqimi.com>
 */

namespace Doqimi;

use Doqimi\Exception\ModelException;
use Doqimi\Exception\RequestException;
use Doqimi\Exception\ResponseException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use GuzzleHttp\RequestOptions;

class BaseClient
{
	const VERSION = '1.0.0';
	const API_URL = 'https://api.payclip.com';
	const USER_AGENT = 'Doqimi-Payclip-PHP-SDK';

	/**
	 * @var ClientInterface
	 */
	private $client;

	/**
	 * @var string
	 */
	private $baseUri = self::API_URL;

	/**
	 * @param string $user
	 * @param string $password
	 * @param array $requestOptions
	 * @param null|ClientInterface $httpClient
	 */
	public function __construct($user = null, $password = null, array $requestOptions = [], ClientInterface $httpClient = null)
	{
		if ($httpClient && $requestOptions) {
			throw new \InvalidArgumentException('If argument 3 is provided, argument 4 must be omitted or passed with `null` as value');
		}
		$requestOptions += [
			RequestOptions::HEADERS => [
				'User-Agent' => self::USER_AGENT.'-v'.self::VERSION
			],
			RequestOptions::AUTH => [$user, $password],
			RequestOptions::CONNECT_TIMEOUT => 10,
			RequestOptions::TIMEOUT => 60,
		];
		$this->client = $httpClient ?: new GuzzleClient($requestOptions);
	}

	/**
	 * @param string $baseUri
	 *
	 * @return Client
	 */
	public function setApiUrl($baseUri)
	{
		$this->baseUri = rtrim($baseUri, '/');

		return $this;
	}

	/**
	 * Get Request
	 *
	 * @param string $path
	 * @param array $params
	 *
	 * @return null|\stdClass|array
	 */
	public function get($path, array $params = [])
	{
		return $this->executeRequest('GET', $path, [RequestOptions::QUERY => $params]);
	}

	/**
	 * POST Request
	 *
	 * @param string $path
	 * @param array|null $body
	 * @param array $params
	 *
	 * @return null|\stdClass|array
	 */
	public function post($path, array $body = [], array $params = null)
	{
		return $this->executeRequest('POST', $path, [RequestOptions::JSON => $body, RequestOptions::QUERY => $params]);
	}

	/**
	 * PUT Request
	 *
	 * @param string $path
	 * @param array|null $body
	 * @param array $params
	 *
	 * @return null|\stdClass|array
	 */
	public function put($path, array $body = null, array $params = [])
	{
		return $this->executeRequest('PUT', $path, [RequestOptions::JSON => $body, RequestOptions::QUERY => $params]);
	}

	/**
	 * DELETE Request
	 *
	 * @param string $path
	 * @param array $params
	 *
	 * @return null|\stdClass|array
	 */
	public function delete($path, array $params = [])
	{
		return $this->executeRequest('DELETE', $path, [RequestOptions::QUERY => $params]);
	}

	/**
	 * Execute the request and return the resulting object
	 *
	 * @param string $method
	 * @param string $url
	 * @param array $options
	 *
	 * @throws \RuntimeException|\LogicException
	 *
	 * @return null|\stdClass|array The decoded JSON representation using `json_decode()`
	 */
	private function executeRequest($method, $url, array $options = [])
	{
		try {
			$response = $this->client->request($method, sprintf('%s/%s', $this->baseUri, $url), $options);
			$content = trim($response->getBody()->getContents());
		} catch (GuzzleRequestException $e) {
			if ($e->hasResponse()) {
				$content = trim($e->getResponse()->getBody()->getContents());
				if ($content && ($object = \GuzzleHttp\json_decode($content)) && isset($object->Message)) {
					$modelException = null;
					if (isset($object->ModelState)) {
						$modelExceptionMessages = [];
						foreach ($object->ModelState as $invalidPropertyMessages) {
							$modelExceptionMessages = array_merge($modelExceptionMessages, $invalidPropertyMessages);
						}
						$modelExceptionMessage = null;
						if ($modelExceptionMessages) {
							$modelExceptionMessage = implode('; ', $modelExceptionMessages).'.';
						}
						$modelException = new ModelException($modelExceptionMessage, $e->getCode());
					}
					throw new RequestException($object->Message, 0, $modelException);
				}

				throw new RequestException($content ?: $e->getMessage(), $e->getCode());
			}

			throw new RequestException($e->getMessage(), $e->getCode());
		}

		if ($content) {
			if (!($object = \GuzzleHttp\json_decode($content)) && JSON_ERROR_NONE !== ($jsonLastError = json_last_error())) {
				throw new ResponseException(
					sprintf('Response body could not be parsed since it doesn\'t contain a valid JSON structure, %s (%d): %s', json_last_error_msg(), $jsonLastError, $content)
				);
			}

			return $object;
		}

		return null;
	}
}
