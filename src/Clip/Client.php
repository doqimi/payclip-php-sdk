<?php

/*
 * This file is part of the Payclip PHP SDK.
 *
 * ©2025 Doqimi <developer@doqimi.com>
 */

namespace Doqimi\Clip;

use Doqimi\BaseClient;

final class Client extends BaseClient
{
	/**
	 * @param string $CLIP_API_KEY
 	 * @param string $CLIP_API_SECRET
	 */
	public function __construct($CLIP_API_KEY = null, $CLIP_API_SECRET = null)
	{
		parent::__construct(
			is_null($CLIP_API_KEY) 		? getenv('CLIP_API_KEY') 	: $CLIP_API_KEY, 
			is_null($CLIP_API_SECRET) 	? getenv('CLIP_API_SECRET') : $CLIP_API_SECRET, 
			[
				'accept'		 => 'application/json',
				'content-type'	 => 'application/json',
			],
			null
		);
	}
}

