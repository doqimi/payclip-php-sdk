<?php

/*
 * This file is part of the Payclip PHP SDK.
 *
 * ©2025 Doqimi <developer@doqimi.com>
 */

namespace Doqimi\Clip\Model;

final class PaymentStatus
{
	public const CHECKOUT_CREATED = 'CHECKOUT_CREATED';
	public const CHECKOUT_PENDING = 'CHECKOUT_PENDING';
	public const CHECKOUT_CANCELLED = 'CHECKOUT_CANCELLED';
	public const CHECKOUT_EXPIRED = 'CHECKOUT_EXPIRED';
	public const CHECKOUT_COMPLETED = 'CHECKOUT_COMPLETED';
}