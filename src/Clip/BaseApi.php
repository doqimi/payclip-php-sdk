<?php

/*
 * This file is part of the Payclip PHP SDK.
 *
 * ©2025 Doqimi <developer@doqimi.com>
 */

namespace Doqimi\Clip;

class BaseApi
{
	protected static function validateClient(Client $client)
	{
		if(!($client instanceof Client))
		{
			throw new \InvalidArgumentException('First parameter is not a valid instance of Doqimi\Clip.');
		}
	}

	protected static function isParamEmpty($key, $paramContext = 'Parameter')
	{
		if(empty($key))
		{
			throw new \InvalidArgumentException("{$paramContext} must not be empty.");
		}
	}

	protected static function validateRequiredPayloadKeys(array $keys, array $payload, $context = 'payload')
	{
		foreach ($keys as $key)
		{
			if (!array_key_exists($key, $payload))
			{
				throw new \InvalidArgumentException("Key {$key} is required in the {$context}.");
			}

			if(empty($payload[$key]))
			{
				throw new \InvalidArgumentException("Key {$key} must not be empty in the {$context}.");
			}
        }
	}

	protected static function isKeyNumeric(array $keys, array $payload)
	{
		foreach ($keys as $key)
		{
			if(!is_numeric($payload[$key]))
			{
				throw new \InvalidArgumentException("Key {$key} must be numeric.");
			}
		}
	}

	protected static function isKeyArray(array $keys, array $payload)
	{
		foreach ($keys as $key)
		{
			if(!is_array($payload[$key]))
			{
				throw new \InvalidArgumentException("Key {$key} must be an array.");
			}
		}
	}
}