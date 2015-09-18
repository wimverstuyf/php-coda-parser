<?php

namespace Codelicious\Coda\Transformation;

use Codelicious\Coda\Data;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class TransformToSimple implements TransformationInterface
{
	/**
	 * @var array
	 */
	protected $_definitionObjects = array(
		self::CLASS_TRANSACTION => '\Codelicious\Coda\Data\Simple\Transaction',
	    self::CLASS_ACCOUNT     => '\Codelicious\Coda\Data\Simple\Account',
	    self::CLASS_STATEMENT   => '\Codelicious\Coda\Data\Simple\Statement',
	);

	/**
	 * Transform Data\Raw\Statements to Data\Simple\Statements
	 *
	 * @param Data\Raw\Statement $coda_statements
	 *
	 * @return Data\Simple\Statement
	 */
	public function transform(Data\Raw\Statement $coda_statements)
	{
		$transactionClass = $this->getSimpleObjectDefinitions();
		/* @var $account_transactions Data\Simple\Statement */
		$account_transactions = new $transactionClass[ self::CLASS_STATEMENT ]();

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

	public function transformToAccount(Data\Raw\Identification $coda_identification, Data\Raw\OriginalSituation $coda_original_situation)
	{
		$accountClass = $this->getSimpleObjectDefinitions();
		$account = new $accountClass[ self::CLASS_ACCOUNT ]();

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

	public function transformToOtherPartyAccount(Data\Raw\Transaction22 $coda_line22 = null, Data\Raw\Transaction23 $coda_line23 = null)
	{
		$accountClass = $this->getSimpleObjectDefinitions();
		$account = new $accountClass[ self::CLASS_ACCOUNT ]();

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

	public function transformMessages(array $coda_messages)
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

	public function transformTransaction(Data\Raw\Transaction $coda_transaction)
	{
		$transactionClass = $this->getSimpleObjectDefinitions();
		$transaction = new $transactionClass[ self::CLASS_TRANSACTION ]();

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

	public function concatenateTransactionMessages(Data\Raw\Transaction $coda_transaction)
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

		if (!$message && $coda_transaction->line22 && $coda_transaction->line22->client_reference)
		{
			$message = $coda_transaction->line22->client_reference;
		}

		return $message;
	}

	public function setSimpleObjectsDefinition(array $definitions)
	{
		foreach ($definitions as $type => $definition)
		{
			$this->_definitionObjects[ $type ]= $$definition;
		}
		return $this;
	}

	public function getSimpleObjectDefinitions()
	{
		return $this->_definitionObjects;
	}
}
