<?php

namespace Codelicious\Coda\Helpers;

use Codelicious\Coda\Exceptions\InvalidValueException;
use Codelicious\Coda\Lines\LineInterface;
use Codelicious\Coda\Lines\LineType;

/**
 * @param array $lines
 * @param LineType $type
 * @return LineInterface|null
 */
function getFirstLineOfType(array $lines, LineType $type)
{
	$filteredLines = array_filter(
		$lines,
		function(LineInterface $line) use ($type) {
			return $line->getType() == $type;
		});
	$line = reset($filteredLines);
	
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
	if ($string === " ") {
		$string = "";
	}
	return $string;
}


function getTrimmedData($data, $startPosition, $length)
{
	return trim(mb_substr($data, $startPosition, $length));
}

/**
 * Convert a coda date to an iso format
 * @param string $dateCoda
 *
 * @return string
 */
function formatDateString(string $dateCoda)
{
	return '20' . mb_substr($dateCoda, 4, 2) . '-' . mb_substr($dateCoda, 2, 2) . '-' . mb_substr($dateCoda, 0, 2);
}

function validateStringLength(string $value, int $expectedLength, string $typeName)
{
	if (mb_strlen($value) != $expectedLength) {
		throw new InvalidValueException($typeName, $value, "Should be $expectedLength long");
	}
}

/**
 * @param string $value
 * @param int[] $expectedLengthArray
 * @param string $typeName
 */
function validateStringMultipleLengths(string $value, array $expectedLengthArray, string $typeName)
{
	$hasLength = false;
	foreach($expectedLengthArray as $expectedLength) {
		if (mb_strlen($value) == $expectedLength) {
			$hasLength = true;
		}
	}
	if (!$hasLength) {
		throw new InvalidValueException($typeName, $value, "Length not valid");
	}
}

function validateStringDigitOnly($value, $typeName)
{
	if (!ctype_digit($value)) {
		throw new InvalidValueException($typeName, $value, "Should contain only numeric values");
	}
}