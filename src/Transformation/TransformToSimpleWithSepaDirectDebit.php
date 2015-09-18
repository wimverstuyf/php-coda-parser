<?php

namespace Codelicious\Coda\Transformation;

use Codelicious\Coda\Data;

/**
 * @package Codelicious\Coda
 * @author Gru=mmfy <me@grummfy.be>
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class TransformToSimpleWithSepaDirectDebit extends TransformToSimple
{
	public function __construct()
	{
		$this->setSimpleObjectsDefinition(array(
			self::CLASS_TRANSACTION => '\Codelicious\Coda\Data\Simple\TransactionSepaDirectDebit',
		));
	}

	public function transformTransaction(Data\Raw\Transaction $coda_transaction)
	{
		$transaction = parent::transformTransaction($coda_transaction);

		$this->transformTransactionWithSdd($coda_transaction, $transaction);

		return $transaction;
	}

	public function transformTransactionWithSdd(Data\Raw\Transaction21SepaDirectDebit $coda_transaction, Data\Simple\TransactionSepaDirectDebit $transaction)
	{
		$transaction->sddType = $coda_transaction->sepa_direct_debit_type;
		$transaction->sddScheme = $coda_transaction->sepa_direct_debit_scheme;
		$transaction->sddPaid = $coda_transaction->sepa_direct_debit_paid_reason;
		$transaction->sddMandat = $coda_transaction->sepa_direct_debit_mandate_ref;
		$transaction->sddCommunication = $coda_transaction->sepa_direct_debit_communication;
	}
}
