<?php

namespace Codelicious\Coda;

function str2Data($data, $startPosition, $length)
{
	return trim(substr($data, $startPosition, $length));
}

function valueObjectCopy2Object($initialObject, $copyObject)
{
	foreach ($initialObject as $key => $value)
	{
		echo $key, '-', $value, PHP_EOL;
		$copyObject->$key = $value;
	}
}
