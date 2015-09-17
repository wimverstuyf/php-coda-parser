<?php

namespace Codelicious\Coda\Transformation;

use Codelicious\Coda\Data;

class TransformationToSimpleAdvanced extends TransformToSimple
{
	public function __construct()
	{
		$this->setSimpleObjectsDefinition(array(
			self::CLASS_TRANSACTION => '\Codelicious\Coda\Data\Simple\Advanced\Transaction',
		));
	}

	public function transformTransaction(Data\Raw\Transaction $coda_transaction)
	{
		$transaction = parent::transformTransaction($coda_transaction);
		$transaction->codeType = substr($coda_transaction->line21->transaction_code, 0, 1);
		$transaction->codeFamily = substr($coda_transaction->line21->transaction_code, 1, 2);
		$transaction->codeTransaction = substr($coda_transaction->line21->transaction_code, 3, 2);
		$transaction->codeCategory = substr($coda_transaction->line21->transaction_code, 5, 3);

		return $transaction;
	}

	public function concatenateTransactionMessages(Data\Raw\Transaction $coda_transaction)
	{
		$message = parent::concatenateTransactionMessages($coda_transaction);
		if (!empty($message))
		{
			return $message;
		}

		if ($coda_transaction->line22->client_reference)
		{
			$message = $coda_transaction->line22->client_reference;
		}

		return $message;
	}
}
