<?php

namespace Codelicious\Coda\Data\Raw;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class OriginalSituation
{
	public $record_code = "1";

	public $sequence_number;
	public $statement_sequence_number;
	public $account_name;
	public $account_description;
	public $account_number_type;
	public $account_number;
	public $account_currency;
	public $account_country;
	public $account_is_iban = FALSE;
	public $balance;
	public $date;
}
