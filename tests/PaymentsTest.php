<?php declare(strict_types=1);

/*
 * This file is part of the Payclip PHP SDK.
 *
 * ©2025 Doqimi <developer@doqimi.com>
 */

namespace Doqimi\Tests;

use Doqimi\Clip\Client;
use Doqimi\Clip\Payments;
use PHPUnit\Framework\TestCase;

class PaymentsTest extends TestCase
{
	protected $client;
	protected static string $receiptNo;

	public function setUp(): void
	{
		parent::setUp();

		$this->client = new Client();
	}

	public function testListReceipts(): void
	{
		try {
			$receipts = Payments::listReceipts($this->client, date('Y-m-d', strtotime('-7 Day')).'T00:00:00.000Z', date('Y-m-d').'T23:59:59.000Z');

			$this->assertTrue(isset($receipts->items) && is_array($receipts->items), "'items' should exist and be an array.");

			$receiptNos = array_map(function ($item) {
				return $item->receipt_no ?? null;
			}, $receipts->items);

			$receiptNos = array_filter($receiptNos);

			$this->assertGreaterThanOrEqual(1, count($receiptNos), 'Expected at least one receipt_no.');

			$this->assertNotEmpty($receiptNos[0], 'First receipt_no should not be empty.');

			self::$receiptNo = $receiptNos[0];
		} catch (\Exception $e) {
			$this->fail("An unexpected exception was thrown: " . $e->getMessage());
		}
	}

	public function testGetReceipt(): void
	{
		try {
			$this->assertNotEmpty(self::$receiptNo, 'No receipt available from previous test.');

			$paymentLink = Payments::getReceipt($this->client, self::$receiptNo);
			
			$this->assertEquals(self::$receiptNo, $paymentLink->item->receipt_no);
		} catch (\Exception $e) {
			$this->fail("An unexpected exception was thrown: " . $e->getMessage());
		}
	}
}