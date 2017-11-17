<?php

namespace Codelicious\Coda;

/**
 * Class Enum
 *
 * Encapsulates (as best as PHP can, Enums as a type)
 * Extend the class and define constants for the valid values
 *
 * This class basically mimics SPLEnum from the SPL-Types PECL
 * extension except in vanilla PHP so no extension required.
 *
 * Example:
 *
 * class MyEnum extends Enum {
 *   const FOO = 1;
 *   const BAR = 2;
 * }
 *
 * $enum = new MyEnum(MyEnum::FOO);
 *
 * $enum = new MyEnum(99); //throws exception because not valid value
 *
 */
abstract class Enum implements \JsonSerializable
{
	/**
	 * @var int
	 */
	protected $value;
	
	/**
	 * @param mixed $value
	 */
	public function __construct($value)
	{
		$this->setValue($value);
	}
	
	/**
	 * @param mixed $value
	 */
	public function setValue($value)
	{
		if (!static::isValid($value)) {
			throw new \InvalidArgumentException(sprintf("Invalid enumeration %s for Enum %s", $value, get_class($this)));
		}
		$this->value = $value;
	}
	
	/**
	 * @return int
	 */
	public function getValue()
	{
		return $this->value;
	}
	
	/**
	 * Check if the set value on this enum is a valid value for the enum
	 * @return boolean
	 */
	public static function isValid($value)
	{
		if (!in_array($value, static::validValues())) {
			return false;
		}
		return true;
	}
	
	/**
	 * Get the valid values for this enum
	 * Defaults to constants you define in your subclass
	 * override to provide custom functionality
	 * @return array
	 */
	public static function validValues()
	{
		$r = new \ReflectionClass(get_called_class());
		return array_values($r->getConstants());
	}
	
	/**
	 * @see JsonSerialize
	 */
	public function jsonSerialize()
	{
		return $this->getValue();
	}
	
	/**
	 * @return string
	 */
	public function __toString()
	{
		return (string)$this->getValue();
	}
}
