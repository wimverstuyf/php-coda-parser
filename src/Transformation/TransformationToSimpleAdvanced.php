<?php

namespace Codelicious\Coda\Transformation;

use Codelicious\Coda\Data;

class TransformationToSimpleAdvanced extends TransformToSimple
{
//	public function transformTransaction(Data\Raw\Transaction $coda_transaction)
//	{
//		return parent::transformTransaction($coda_transaction);
//		/*
//		$transaction = new Transaction();
//		$transaction->account = $this->transformToOtherPartyAccount($coda_transaction->line22, $coda_transaction->line23);
//
//		if ($coda_transaction->line21) {
//			$transaction->valuta_date = $coda_transaction->line21->valuta_date;
//			$transaction->transaction_date = $coda_transaction->line21->transaction_date;
//			$transaction->amount = $coda_transaction->line21->amount;
//		}
//
//		if ($coda_transaction->line21 && $coda_transaction->line21->structured_message) {
//			$transaction->structured_message = $coda_transaction->line21->structured_message;
//		} elseif ($coda_transaction->line31 && $coda_transaction->line31->structured_message) {
//			$transaction->structured_message = $coda_transaction->line31->structured_message;
//		}
//
//		$transaction->message = $this->concatenateTransactionMessages($coda_transaction);
//
//		return $transaction;
//		*/
//	}

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
