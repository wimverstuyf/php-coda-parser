<?php

namespace Codelicious\Coda;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Parser
{
	/**
	 * Read the given file and parse the content into an array of objects
	 *
	 * @param string $coda_file
	 * @param string $output_format Possible values: raw, full (=not yet implemented), simple
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
	 * @param string $output_format Possible values: raw, full (=not yet implemented), simple
	 * @return array
	 */
	public function parse($coda_lines, $output_format="raw")
	{
		$coda_lines = $this->convertToObjects($coda_lines);

		$list = $this->convertToRaw($coda_lines);

		if ($output_format=="simple") {
			$transformation = new \Codelicious\Coda\DetailParsers\TransformToSimple();
			$list = $transformation->transform($list);
		}
		elseif ($output_format=="full") {
			throw new Exception("Format 'full' not yet supported");
		}

		return $list;
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
				$current_account_transaction = new \Codelicious\Coda\Data\Raw\Statement();
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
					array_push($current_account_transaction->transactions, new \Codelicious\Coda\Data\Raw\Transaction());
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

	private function getDetailParsers()
	{
		return array(
			new \Codelicious\Coda\DetailParsers\IdentificationParser(),
			new \Codelicious\Coda\DetailParsers\OriginalSituationParser(),
			new \Codelicious\Coda\DetailParsers\Transaction21Parser(),
			new \Codelicious\Coda\DetailParsers\Transaction22Parser(),
			new \Codelicious\Coda\DetailParsers\Transaction23Parser(),
			new \Codelicious\Coda\DetailParsers\Transaction31Parser(),
			new \Codelicious\Coda\DetailParsers\Transaction32Parser(),
			new \Codelicious\Coda\DetailParsers\Transaction33Parser(),
			new \Codelicious\Coda\DetailParsers\MessageParser(),
			new \Codelicious\Coda\DetailParsers\NewSituationParser(),
			new \Codelicious\Coda\DetailParsers\SummaryParser(),
			);
	}
}
