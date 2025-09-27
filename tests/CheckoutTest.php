<?php declare(strict_types=1);

/*
 * This file is part of the Payclip PHP SDK.
 *
 * ©2025 Doqimi <developer@doqimi.com>
 */

namespace Doqimi\Tests;

use Doqimi\Clip\Client;
use Doqimi\Clip\Checkout;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
	protected $client;
	protected static string $payment_request_id;

	public function setUp(): void
	{
		parent::setUp();

		$this->client = new Client();
	}

	public function testCreatePaymentLink(): void
	{
		try {
			$payload = [
				"amount" => 1.00,
				"currency" => "MXN",
				"purchase_description" => "Payclip PHP SDK by Doqimi Test",
				"redirection_url" => [
					"success" 	=> "https://my-website.com/redirection/success",
					"error"		=> "https://my-website.com/redirection/error",
					"default"	=> "https://my-website.com/redirection/default",
				]
			];

			$paymentLink = Checkout::createPaymentLink($this->client, $payload);

			$this->assertEquals('CHECKOUT_CREATED', $paymentLink->status);

			$this->assertTrue(isset($paymentLink->payment_request_id), 'payment_request_id should exist');
			
			$this->assertNotEmpty($paymentLink->payment_request_id, 'payment_request_id should not be empty');

			self::$payment_request_id = $paymentLink->payment_request_id;
		} catch (\Exception $e) {
			$this->fail("An unexpected exception was thrown: " . $e->getMessage());
		}
	}

	public function testGetPaymentLink(): void
	{
		try {
			$this->assertNotEmpty(self::$payment_request_id, 'No payment_request_id available from previous test.');

			$paymentLink = Checkout::getPaymentLink($this->client, self::$payment_request_id);

			$this->assertEquals(self::$payment_request_id, $paymentLink->payment_request_id);
		} catch (\Exception $e) {
			$this->fail("An unexpected exception was thrown: " . $e->getMessage());
		}
	}
}