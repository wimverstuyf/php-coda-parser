<?php

namespace Codelicious\Coda\Data;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class OriginalSituation
{
	public $account_number_type;
	public $statement_sequence_number;
	public $account_number;
	public $account_currency;
	public $account_country;
	public $is_iban = FALSE;
	public $amount; // integer, last 3 digits are decimals
	public $date;
	public $account_holder_name;
	public $account_description;
	public $sequence_number;
}
			