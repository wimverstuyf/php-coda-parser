<?php

namespace Codelicious\Coda;

use Codelicious\Coda\Data\Raw;
use Codelicious\Coda\DetailParsers;
use Codelicious\Coda\Transformation\TransformationInterface;
use Codelicious\Coda\Transformation\TransformToSimple;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Parser
{
	/**
	 * DetailParsers instances
	 * @var array
	 */
	protected $_detailParsers;

	/**
	 * Read the given file and parse the content into an array of objects
	 *
	 * @param string $coda_file
	 * @param string $output_format Possible values: raw, simple, full (=not yet implemented)
	 * @return array
	 */
	public function parseFile($coda_file, $output_format="raw")
	{
		return $this->parse(file($coda_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES), $output_format);
	}

	/**
	 * Parse the given array of string into an array of objects
	 *
	 * @param array $coda_lines
	 * @param string $output_format Possible values: raw, simple, full (=not yet implemented)
	 * @return array
	 * @throws Exception
	 */
	public function parse($coda_lines, $output_format="raw")
	{
		$rawLines = $this->parseToRaw($coda_lines);

		if ($output_format=="simple") {
			$transformation = new TransformToSimple();
			return $this->transformRaw($rawLines, $transformation);
		}
		elseif ($output_format=="full") {
			throw new Exception("Format 'full' not yet supported");
		}

		return $rawLines;
	}

	/**
	 * Convert an array of coda line to an array of raw coda lines
	 * @param array $codaLines
	 *
	 * @return array
	 */
	public function parseToRaw(array $codaLines)
	{
		$codaLines = $this->convertToObjects($codaLines);
		return $this->convertToRaw($codaLines);
	}

	/**
	 * Transform raw result to useful results through the $transformation
	 * @param array                   $rawList
	 * @param TransformationInterface $transformation
	 *
	 * @return array
	 */
	public function transformRaw(array $rawList, TransformationInterface $transformation)
	{
		$list = array();
		foreach ($rawList as $raw)
		{
			array_push($list, $transformation->transform($raw));
		}
		return $list;
	}

	public function setDetailParser(array $detailParsers)
	{
		$this->_detailParsers = $detailParsers;
	}

	/**
	 * Return the current detail parser setted or initialized a valid set
	 * @return array
	 */
	public function getDetailParsers()
	{
		if (empty($this->_detailParsers))
		{
			$this->_detailParsers = array(
				new DetailParsers\IdentificationParser(),
				new DetailParsers\OriginalSituationParser(),
				new DetailParsers\Transaction21Parser(),
				new DetailParsers\Transaction22Parser(),
				new DetailParsers\Transaction23Parser(),
				new DetailParsers\Transaction31Parser(),
				new DetailParsers\Transaction32Parser(),
				new DetailParsers\Transaction33Parser(),
				new DetailParsers\MessageParser(),
				new DetailParsers\NewSituationParser(),
				new DetailParsers\SummaryParser(),
			);
		}

		return $this->_detailParsers;
	}

	private function convertToRaw($coda_lines)
	{
		$statements_list = array();

		$current_account_transaction = NULL;
		$current_transaction_sequence_number = NULL;
		foreach ($coda_lines as $coda_line) {
			if ($coda_line->record_code == "0") {
				if ($current_account_transaction)
					array_push($statements_list, $current_account_transaction);
				$current_account_transaction = new Raw\Statement();
				$current_transaction_sequence_number = NULL;
				$current_account_transaction->identification = $coda_line;
			}
			elseif ($coda_line->record_code == "1") {
				$current_account_transaction->original_situation = $coda_line;
			}
			elseif ($coda_line->record_code == "4") {
				array_push($current_account_transaction->messages, $coda_line);
			}
			elseif ($coda_line->record_code == "8") {
				$current_account_transaction->new_situation = $coda_line;
			}
			elseif ($coda_line->record_code == "9") {
				$current_account_transaction->summary = $coda_line;
			}
			elseif ($coda_line->record_code == "2" || $coda_line->record_code == "3") {
				$trans_idx = count($current_account_transaction->transactions) - 1;
				if ($trans_idx < 0 || $current_transaction_sequence_number != $coda_line->sequence_number) {
					$trans_idx += 1;
					$current_transaction_sequence_number = $coda_line->sequence_number;
					array_push($current_account_transaction->transactions, new Raw\Transaction());
				}
				$current_account_transaction->transactions[$trans_idx]->{'line'.$coda_line->record_code.$coda_line->article_code} = $coda_line;
			}
		}

		if ($current_account_transaction)
			array_push($statements_list, $current_account_transaction);

		return $statements_list;
	}

	private function convertToObjects($coda_lines)
	{
		$parsers = $this->getDetailParsers();

		$object_list = array();
		foreach($coda_lines as $line) {
			$object = NULL;

			foreach($parsers as $parser) {
				if ($parser->accept_string($line)) {
					$object = $parser->parse($line);
					break;
				}
			}

			if ($object) {
				array_push($object_list, $object);
			}
		}

		return $object_list;
	}
}
