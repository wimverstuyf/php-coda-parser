<?php

namespace Codelicious\Coda;

use Codelicious\Coda\Lines\LineInterface;
use Codelicious\Coda\Lines\LineType;
use Codelicious\Coda\StatementParsers\StatementParser;
use Codelicious\Coda\Statements\Statement;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Parser implements ParserInterface
{
	/** @var LinesParser */
	private $linesParser;
	
	public function __construct()
	{
	    $this->linesParser = new LinesParser();
	}
	
	/**
	 * @param string $codaFile
	 * @return Statement[]
	 */
	public function parseFile(string $codaFile): array
	{
		$lines = $this->linesParser->parseFile($codaFile);
		return $this->convertToStatements($lines);
	}
	
	/**
	 * @param string[] $codaLines
	 * @return Statement[]
	 */
	public function parse(array $codaLines): array
	{
		$lines = $this->linesParser->parse($codaLines);
		return $this->convertToStatements($lines);
	}
	
	/**
	 * @param LineInterface[] $lines
	 * @return Statement[]
	 */
	private function convertToStatements(array $lines): array
	{
		$linesGroupedPerStatement = $this->groupTransactionsPerStatement($lines);
		
		$statements = [];
		$parser = new StatementParser();
		foreach($linesGroupedPerStatement as $linesForStatement) {
			$statement = $parser->parse($linesForStatement);
			
			array_push($statements, $statement);
		}
		
		return $statements;
	}
	
	/**
	 * @param LineInterface[] $lines
	 * @return LineInterface[][]
	 */
	public function groupTransactionsPerStatement(array $lines)
	{
		$statements = [];
		$idx = -1;
		
		foreach($lines as $line) {
			if (!$statements || $line->getType()->getValue() == LineType::Identification) {
				$idx += 1;
				$statements[$idx] = [];
			}
			
			array_push($statements[$idx], $line);
		}
		
		return $statements;
	}
}
