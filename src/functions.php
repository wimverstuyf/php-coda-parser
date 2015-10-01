<?php


/**
 * Trim multiple spaces in beginning or end to single space
 */
function trim_space($string)
{
	$string = preg_replace('/^ +/', ' ', $string);
	$string = preg_replace('/ +$/', ' ', $string);
	return $string;
}


function codaStr2Data($data, $startPosition, $length)
{
	return trim(substr($data, $startPosition, $length));
}

/**
 * Copy the value object fields (public) to the other one
 * @param object $initialObject
 * @param object $copyObject
 */
function codaValueObjectCopy2Object($initialObject, $copyObject)
{
	foreach ($initialObject as $key => $value)
	{
		$copyObject->$key = $value;
	}
}

/**
 * Convert a coda date to an iso format
 * @param string $dateCoda
 *
 * @return string
 */
function coda2Date($dateCoda)
{
	return '20' . substr($dateCoda, 4, 2) . '-' . substr($dateCoda, 2, 2) . '-' . substr($dateCoda, 0, 2);
}