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

	// Param validations

	protected static function isParamEmpty($param, $paramName = 'undefined')
	{
		if(empty($param))
		{
			throw new \InvalidArgumentException("Param {$paramName} must not be empty.");
		}
	}

	protected static function isParamValidISO8601(string $param, $paramName = 'undefined')
	{
		$date = DateTime::createFromFormat('Y-m-d\TH:i:s.v\Z', $param);

		if(!($date && $date->format('Y-m-d\TH:i:s.v\Z') === $param))
		{
			throw new \InvalidArgumentException("Param {$paramName} must be a valid ISO8601 date string.");
		}
	}

	protected static function isParamInEnum(string $param, array $enum = [], $paramName = 'undefined')
	{
		if(!in_array($param, $enum))
		{
			throw new \InvalidArgumentException("Param {$paramName} must be one of the defined valid values.");
		}
	}

	protected static function isParamLengthValid(string $param, int $length = 0, $paramName = 'undefined')
	{
		if(strlen($param) !== $length)
		{
			throw new \InvalidArgumentException("Param {$paramName} must have a length of {$length}.");
		}
	}

	// Payload Key Validations

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