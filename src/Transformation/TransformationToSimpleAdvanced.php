<?php

namespace Codelicious\Coda\Transformation;

use Codelicious\Coda\Data;

class TransformationToSimpleAdvanced extends TransformToSimple
{
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
