<?php

namespace Codelicious\Coda\Data\Raw;

/**
 * @package Codelicious\Coda
 * @author Grummfy <me@grummfy.be>
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Transaction21SepaDirectDebit extends Transaction21
{
	public $sepa_direct_debit_settlement_date;
	public $sepa_direct_debit_type;
	public $sepa_direct_debit_scheme;
	public $sepa_direct_debit_paid_reason;
	public $sepa_direct_debit_creditor_id_code;
	public $sepa_direct_debit_mandate_ref;
	public $sepa_direct_debit_communication;
	public $sepa_direct_debit_type_r_ref;
	public $sepa_direct_debit_reason;
}
