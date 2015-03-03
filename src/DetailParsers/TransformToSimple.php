<?php

namespace Codelicious\Coda\DetailParsers;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class TransformToSimple
{
	/**
	 * Transform Data\Raw\Statements to Data\Simple\Statements
	 *
	 * @param Data\Raw\Statements $coda_statements
	 * @return Data\Simple\Statements
	 */
	public function transform($coda_statements)
	{
		$account_transactions = new \Codelicious\Coda\Data\Simple\Statement();

		if ($coda_statements->identification) {
			$account_transactions->date = $coda_statements->identification->creation_date;
		}
		
		$account_transactions->account = $this->transformToAccount($coda_statements->identification, $coda_statements->original_situation);

		if ($coda_statements->original_situation) {
			$account_transactions->original_balance = $coda_statements->original_situation->balance;
		}

		if ($coda_statements->new_situation) {
			$account_transactions->new_balance = $coda_statements->new_situation->balance;
		}

		if ($coda_statements->messages) {
			$account_transactions->free_message = $this->transformMessages($coda_statements->messages);
		}

		if ($coda_statements->transactions) {
			foreach ($coda_statements->transactions as $transaction) {
				array_push($account_transactions->transactions, $this->transformTransaction($transaction));
			}
		}

		return $account_transactions;
	}

	public function transformToAccount($coda_identification, $coda_original_situation)
	{
		$account = new \Codelicious\Coda\Data\Simple\Account();

		if ($coda_identification) {
			$account->name = $coda_identification->account_name;
			$account->bic = $coda_identification->account_bic;
			$account->company_id = $coda_identification->account_company_identification_number;
		}
		if ($coda_original_situation) {
			$account->number = $coda_original_situation->account_number;
			$account->currency = $coda_original_situation->account_currency;
			$account->country = $coda_original_situation->account_country;
		}

		return $account;
	}

	public function transformToOtherPartyAccount($coda_line22, $coda_line23)
	{
		$account = new \Codelicious\Coda\Data\Simple\Account();

		if ($coda_line22) {
			$account->bic = $coda_line22->other_account_bic;
		}
		if ($coda_line23) {
			$account->number = $coda_line23->other_account_number_and_currency;
			$account->name = $coda_line23->other_account_name;

			// let's try to parse number and currency
			if ($account->number) {
				$last_space = strrpos($account->number, " ");
				if ($last_space !== FALSE) {
					$account->currency = trim(substr($account->number, $last_space));
					$account->number = trim(substr($account->number, 0, $last_space));
				}
			}
		}

		return $account;
	}

	public function transformMessages($coda_messages)
	{
		$message = "";

		foreach ($coda_messages as $msg) {
			$trimmed_content = trim($msg->content);
			if ($trimmed_content && $message)
				$message .= " ";
			$message .= $trimmed_content;
		}

		return $message;
	}

	public function transformTransaction($coda_transaction)
	{
		$transaction = new \Codelicious\Coda\Data\Simple\Transaction();
		$transaction->account = $this->transformToOtherPartyAccount($coda_transaction->line22, $coda_transaction->line23);

		if ($coda_transaction->line21) {
			$transaction->valuta_date = $coda_transaction->line21->valuta_date;
			$transaction->transaction_date = $coda_transaction->line21->transaction_date;
			$transaction->amount = $coda_transaction->line21->amount;
		}

		if ($coda_transaction->line21 && $coda_transaction->line21->structured_message) {
			$transaction->structured_message = $coda_transaction->line21->structured_message;
		} elseif ($coda_transaction->line31 && $coda_transaction->line31->structured_message) {
			$transaction->structured_message = $coda_transaction->line31->structured_message;
		}

		$transaction->message = $this->concatenateTransactionMessages($coda_transaction);

		return $transaction;
	}

	public function concatenateTransactionMessages($coda_transaction)
	{
		$message = "";

		if ($coda_transaction->line21 && $coda_transaction->line21->message) {
			$message .= $coda_transaction->line21->message;

			if ($coda_transaction->line22 && $coda_transaction->line22->message) {
				$message .= $coda_transaction->line22->message;
			}
			if ($coda_transaction->line23 && $coda_transaction->line23->message) {
				$message .= $coda_transaction->line23->message;
			}
		}

		// if message from 2x already contains information then discard the message from 3x
		if (!$message) {
			if ($coda_transaction->line31 && $coda_transaction->line31->message) {
				$message .= $coda_transaction->line31->message;

				if ($coda_transaction->line32 && $coda_transaction->line32->message) {
					$message .= $coda_transaction->line32->message;
				}
				if ($coda_transaction->line33 && $coda_transaction->line33->message) {
					$message .= $coda_transaction->line33->message;
				}
			}
		}

		return $message;
	}
}
