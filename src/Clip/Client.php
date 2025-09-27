<?php

/*
 * This file is part of the Payclip PHP SDK.
 *
 * ©2025 Doqimi <developer@doqimi.com>
 */

namespace Doqimi\Clip;

use Doqimi\BaseClient;
use GuzzleHttp\RequestOptions;

final class Client extends BaseClient
{
	/**
	 * @param string|null $CLIP_API_KEY
 	 * @param string|null $CLIP_API_SECRET
	 * @param array $HEADERS
	 */
	public function __construct(?string $CLIP_API_KEY = null, ?string $CLIP_API_SECRET = null)
	{
		$CLIP_API_KEY = $CLIP_API_KEY ?? getenv('CLIP_API_KEY');
		$CLIP_API_SECRET = $CLIP_API_SECRET	?? getenv('CLIP_API_SECRET');

		parent::__construct(
			[
				RequestOptions::AUTH => [$CLIP_API_KEY, $CLIP_API_SECRET],
				RequestOptions::HEADERS => [
					'accept'		=> 'application/json',
					'content-type'	=> 'application/json',
					'X-API-KEY'		=> 'Basic '.base64_encode("{$CLIP_API_KEY}:{$CLIP_API_SECRET}"),
				],
				//RequestOptions::DEBUG => true,
			],
			null
		);
	}
}

