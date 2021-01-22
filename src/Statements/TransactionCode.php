<?php

namespace Codelicious\Coda\Statements;

/**
 * @package Codelicious\Coda
 * @author Christophe GOsiau (christophe.gosiau@tigron.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class TransactionCode
{
	/** @var string */
	private $family;
	/** @var string */
	private $type;
	/** @var string */
	private $operation;
	/** @var string */
	private $category;
	
	public function __construct(string $family, string $type, string $operation, string $category)
	{
		$this->family = $family;
		$this->type = $type;
		$this->operation = $operation;
		$this->category = $category;
	}
	
	public function getFamily(): string
	{
		return $this->family;
	}
	
	public function getType(): string
	{
		return $this->type;
	}
	
	public function getOperation(): string
	{
		return $this->operation;
	}
	
	public function getCategory(): string
	{
		return $this->category;
	}
}
