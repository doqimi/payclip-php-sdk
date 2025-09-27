<?php declare(strict_types=1);

/*
 * This file is part of the Payclip PHP SDK.
 *
 * ©2025 Doqimi <developer@doqimi.com>
 */

namespace Doqimi\Tests;

use Doqimi\Clip\Client;
use Doqimi\Clip\Settlements;
use PHPUnit\Framework\TestCase;

class SettlementsTest extends TestCase
{
	protected $client;
	protected static string $settlement_report_id;
	protected static string $settlement_report_guid;

	public function setUp(): void
	{
		parent::setUp();

		$this->client = new Client();
	}

	public function testListSettlements(): void
	{
		try {
			$list = Settlements::listSettlements($this->client, date('Y-m-d', strtotime('-60 Day')), date('Y-m-d'));

			$this->assertTrue(isset($list->settlements) && is_array($list->settlements), "'settlements' should exist and be an array.");

			$settlementsIds = [];
			$settlementsGuids = [];

			foreach($list->settlements as $settlement)
			{
				$settlementsIds[] 	= isset($settlement->settlement_report_id) ? basename($settlement->settlement_report_id) : null;
				$settlementsGuids[] = isset($settlement->links->self->href) ? basename($settlement->links->self->href) : null;
			}

			$this->assertGreaterThanOrEqual(1, count($settlementsIds), 'Expected at least one settlement.');

			$this->assertNotEmpty($settlementsIds[0], 'First settlement_report_id should not be empty.');
			$this->assertNotEmpty($settlementsGuids[0], 'First settlement_report_guid should not be empty.');

			self::$settlement_report_id = $settlementsIds[0];
			self::$settlement_report_guid = $settlementsGuids[0];
		} catch (\Exception $e) {
			$this->fail("An unexpected exception was thrown: " . $e->getMessage());
		}
	}

	public function testGetSettlementReportId(): void
	{
		try {
			$this->assertNotEmpty(self::$settlement_report_guid, 'No settlement report guid available from previous test.');

			$report = Settlements::getSettlementReportId($this->client, self::$settlement_report_guid);

			$this->assertEquals(self::$settlement_report_id, $report->settlement->settlement_report_id);
		} catch (\Exception $e) {
			$this->fail("An unexpected exception was thrown: " . $e->getMessage());
		}
	}
}