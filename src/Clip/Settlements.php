<?php

/*
 * This file is part of the Payclip PHP SDK.
 *
 * ©2025 Doqimi <developer@doqimi.com>
 */

namespace Doqimi\Clip;

final class Settlements extends BaseApi
{
	const API_URL = 'https://api-gw.payclip.com';

	/**
	 * @param Client $client
	 * @param string $from
	 * @param string $to
	 * @return mixed
	 */
	public static function listSettlements(Client $client, string $from, string $to)
	{
		self::validateClient($client);

		self::isParamEmpty($from, 'from');
		self::isParamValidDateFormat($from, 'Y-m-d', 'from');

		self::isParamEmpty($to, 'to');
		self::isParamValidDateFormat($to, 'Y-m-d', 'to');

		$now = new \DateTime('now');
		$datetimeFrom = new \DateTime($from);
		$datetimeTo = new \DateTime($to);

		$ninetyDaysAgo = (clone $now)->sub(new \DateInterval('P91D'));

		if($datetimeFrom < $ninetyDaysAgo)
		{
			throw new \InvalidArgumentException('The "from" date cannot be more than 90 days in the past');
		}

		if($datetimeFrom > $datetimeTo)
		{
			throw new \InvalidArgumentException('The "to" date must be equal to or later than the "from" date.');
		}

		$params = [
			'from' => $from,
			'to' => $to,
		];

		$client->setApiUrl(self::API_URL);

		return $client->get('settlements', $params);
	}

	/**
	 * @param Client $client
	 * @param string $settlement_report_id
	 * @return mixed
	 */
	public static function getSettlementReportId(Client $client, string $settlement_report_id)
	{
		self::validateClient($client);
		self::isParamEmpty($settlement_report_id, 'settlement_report_id');

		$client->setApiUrl(self::API_URL);

		return $client->get('settlements/'.$settlement_report_id);
	}
}