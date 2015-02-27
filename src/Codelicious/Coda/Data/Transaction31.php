<?php

namespace Codelicious\Coda\Data;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Transaction31
{
	public $record_code = "3";
	public $article_code = "1";

	public $sequence_number;
	public $sequence_number_detail;
	public $bank_reference;
	public $transaction_code;
	public $message;
	public $has_structured_message = FALSE;
	public $structured_message_full;
	public $structured_message;
}
