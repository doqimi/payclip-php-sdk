<?php

/*
 * This file is part of the Payclip PHP SDK.
 *
 * ©2025 Doqimi <developer@doqimi.com>
 */

namespace Doqimi\Clip;

final class Checkout extends BaseApi
{
	const API_URL = 'https://api.payclip.com';

	/**
	 * @param Client $client
	 * @param array $payload
	 * @return mixed
	 */
	public static function createPaymentLink(Client $client, array $payload = [])
	{
		self::validateClient($client);

		self::validateRequiredPayloadKeys(
			[
				'amount', 
				'currency', 
				'purchase_description', 
				'redirection_url'
			],
			$payload
		);

		self::isKeyNumeric(
			[
				'amount'
			],
			$payload
		);

		self::isKeyArray(
			[
				'redirection_url'
			],
			$payload
		);

		self::validateRequiredPayloadKeys(
			[
				'success',
				'error',
				'default'
			],
			$payload['redirection_url'],
			'redirection_url'
		);

		$client->setApiUrl(self::API_URL);
		
		return $client->post('v2/checkout',	$payload);
	}

	/**
	 * @param Client $client
	 * @param string $payment_request_id
	 * @return mixed
	 */
	public static function getPaymentLink(Client $client, string $payment_request_id)
	{
		self::validateClient($client);
		self::isParamEmpty($payment_request_id, 'payment_request_id');

		$client->setApiUrl(self::API_URL);

		return $client->get('v2/checkout/'.$payment_request_id);
	}
}