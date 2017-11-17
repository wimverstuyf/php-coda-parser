<?php

namespace Codelicious\Coda;

use Codelicious\Coda\LineParsers\LineParserInterface;
use Codelicious\Coda\Lines\LineInterface;
use Exception;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class LinesParser implements ParserInterface
{
	/** @var LineParserInterface[] */
	private $lineParsers;
	
	public function __construct()
	{
		$this->initLineParsers();
	}
	
	/**
	 * @param string $codaFile
	 * @return LineInterface[]
	 */
	public function parseFile(string $codaFile): array
	{
		return $this->parse($this->fileToCodaLines($codaFile));
	}
	
	/**
	 * @param string[] $codaLines
	 * @return LineInterface[]
	 * @throws Exception
	 */
	public function parse(array $codaLines): array
	{
		$list = [];
		
		foreach($codaLines as $line) {
			if (!empty($line)) {
				/** @var LineInterface|null $lineObject */
				$lineObject = null;
				
				/** @var LineParserInterface $parser */
				foreach($this->lineParsers as $parser) {
					if ($parser->canAcceptString($line)) {
						$lineObject = $parser->parse($line);
						break;
					}
				}
				
				if (!$lineObject) {
					throw new Exception("Could not parse");
				}
				
				array_push($list, $lineObject);
			}
		}
		
		if (!$list) {
			throw new Exception("No data given");
		}
		
		return $list;
	}
	
	private function initLineParsers()
	{
		$this->lineParsers = [
			new LineParsers\IdentificationLineParser(),
			new LineParsers\InitialStateLineParser(),
			new LineParsers\TransactionPart1LineParser(),
			new LineParsers\TransactionPart2LineParser(),
			new LineParsers\TransactionPart3LineParser(),
			new LineParsers\InformationPart1LineParser(),
			new LineParsers\InformationPart2LineParser(),
			new LineParsers\InformationPart3LineParser(),
			new LineParsers\MessageLineParser(),
			new LineParsers\NewStateLineParser(),
			new LineParsers\EndSummaryLineParser(),
		];
	}
	
	/**
	 * Read contents from file and put every line as an entry in the result array
	 *
	 * @param string $codaFile Filepath
	 * @return string[]
	 */
	private function fileToCodaLines(string $codaFile): array
	{
		return file($codaFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	}
}