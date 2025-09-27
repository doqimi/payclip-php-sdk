<?php

/*
 * This file is part of the Payclip PHP SDK.
 *
 * ©2025 Doqimi <developer@doqimi.com>
 */

namespace Doqimi\Clip;

final class Payments extends BaseApi
{
	const API_URL = 'https://api-gw.payclip.com';

	/**
	 * @param Client $client
	 * @param string $payment_request_id
	 * @return mixed
	 */
	public static function getReceipt(Client $client, string $receipt_no = "5mUV5Dt")
	{
		self::validateClient($client);

		$client->setApiUrl(self::API_URL);

		return $client->get('payments/receipt-no/'.$receipt_no);
	}

	/**
	 * @param Client $client
	 * @param string $from
	 * @param string $to
	 * @param string|null $status
	 * @param string|null $last4
	 * @param int $limit
	 * @param string|null $paginationToken
	 * @return mixed
	 */
	public static function listReceipts(Client $client, string $from, string $to, ?string $status = null, ?string $last4 = null, int $limit = 20, ?string $paginationToken = null)
	{
		self::validateClient($client);

		self::isParamEmpty($from, 'from');
		self::isParamValidDateFormat($from, 'Y-m-d\TH:i:s.v\Z', 'from');

		self::isParamEmpty($to, 'to');
		self::isParamValidDateFormat($to, 'Y-m-d\TH:i:s.v\Z', 'to');

		if($limit < 1) $limit = 20;
		if($limit > 100) $limit = 100;

		$params = [
			'from' => $from,
			'to' => $to,
			'limit' => $limit,
		];

		if($status !== null)
		{
			self::isParamInEnum($status, ['paid', 'cancelled'], 'status');
			$params['status'] = $status;
		}
		
		if($last4 !== null)
		{
			self::isParamLengthValid($last4, 4, 'last4');
			$params['last4'] = $last4;
		}

		if($paginationToken !== null)
		{
			$params['paginationToken'] = $paginationToken;
		}

		$client->setApiUrl(self::API_URL);

		return $client->get('payments', $params);
	}
}