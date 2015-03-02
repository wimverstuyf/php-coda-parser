<?php

namespace Codelicious\Coda\Data;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Identification
{
	public $record_code = "0";
	
	public $creation_date;
	public $bank_identification_number;
	public $is_duplicate = FALSE;
	public $application_code;
	public $file_reference;
	public $account_name;
	public $account_bic;
	public $account_company_identification_number;
	public $external_application_code;
	public $transaction_reference;
	public $related_reference;
	public $version_code;
}
