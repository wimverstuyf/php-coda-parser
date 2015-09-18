<?php

namespace Codelicious\Coda\Transformation;

use Codelicious\Coda\Data;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
interface TransformationInterface
{
	/**
	 * Transform Data\Raw\Statements to Data\Simple\Statements
	 *
	 * @param Data\Raw\Statement $coda_statements
	 *
	 * @return Data\Simple\Statements
	 */
	public function transform($coda_statements);

	public function transformToAccount($coda_identification, $coda_original_situation);

	public function transformToOtherPartyAccount($coda_line22, $coda_line23);

	public function transformMessages($coda_messages);

	public function transformTransaction($coda_transaction);

	public function concatenateTransactionMessages($coda_transaction);
}