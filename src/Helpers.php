<?php

namespace Codelicious\Coda\Helpers;

use Codelicious\Coda\Lines\LineInterface;

/**
 * @param array $lines
 * @param LineType $type
 * @return LineInterface|null
 */
function getFirstLineOfType(array $lines, LineType $type)
{
	$line = reset(array_filter(
		$lines,
		function(LineInterface $line) use ($type) {
			return $line->getType() == $type;
		})
	);
	
	return $line?$line:null;
}

/**
 * @param LineInterface[] $lines
 * @param LineType[] $types
 * @return LineInterface[]
 */
function filterLinesOfTypes(array $lines, array $types)
{
	$typeValues = array_map(
		function(LineType $type) {
			return $type->getValue();
		}, $types);
	
	return array_filter(
		$lines,
		function(LineInterface $line) use ($typeValues) {
			return in_array($line->getType()->getValue(), $typeValues);
		});
}


/**
 * Trim multiple spaces in beginning or end to single space
 */
function trimSpace($string)
{
	$string = preg_replace('/^ +/', ' ', $string);
	$string = preg_replace('/ +$/', ' ', $string);
	return $string;
}


function getTrimmedData($data, $startPosition, $length)
{
	return trim(substr($data, $startPosition, $length));
}

/**
 * Convert a coda date to an iso format
 * @param string $dateCoda
 *
 * @return string
 */
function formatDateString($dateCoda)
{
	return '20' . substr($dateCoda, 4, 2) . '-' . substr($dateCoda, 2, 2) . '-' . substr($dateCoda, 0, 2);
}