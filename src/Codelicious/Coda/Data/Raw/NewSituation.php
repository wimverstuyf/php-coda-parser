<?php

namespace Codelicious\Coda\Data\Raw;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class NewSituation
{
	public $record_code = "8";

	public $statement_sequence_number;
	public $account_number;
	public $account_is_iban = FALSE;
	public $account_currency;
	public $account_country;
	public $balance;
	public $date;
}
