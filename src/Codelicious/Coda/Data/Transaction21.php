<?php

namespace Codelicious\Coda\Data;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Transaction21
{
	public $sequence_number;
	public $sequence_number_detail;
	public $bank_reference;
	public $amount;
	public $valuta_date;
	public $transaction_code;
	public $message;
	public $has_structured_message = FALSE;
	public $structured_message_type;
	public $structured_message_full;
	public $structured_message;
	public $transaction_date;
	public $statement_sequence_number;
	public $globalization_code;
}
