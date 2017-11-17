<?php

namespace Codelicious\Coda\Lines;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class TransactionPart1Line implements LineInterface
{
	/** @var */
	private $sequenceNumber;
	/** @var */
	private $sequenceNumberDetail;
	/** @var */
	private $bankReference;
	/** @var */
	private $amount;
	/** @var */
	private $valutaDate;
	/** @var */
	private $transactionCode;
	/** @var */
	private $transactionCodeType;
	/** @var */
	private $transactionCodeFamily;
	/** @var */
	private $transactionCodeOperation;
	/** @var */
	private $transactionCodeCategory;
	/** @var */
	private $message;
	/** @var bool */
	private $hasStructuredMessage;
	/** @var */
	private $structuredMessageType;
	/** @var */
	private $structuredMessageFull;
	/** @var */
	private $structuredMessage;
	/** @var */
	private $transactionDate;
	/** @var */
	private $statementSequenceNumber;
	/** @var */
	private $globalizationCode;
	/** @var SepaDirectDebit|null */
	private $sepaDirectDebit;
	
	public function __construct(
		$sequenceNumber,
		$sequenceNumberDetail,
		$bankReference,
		$amount,
		$valutaDate,
		$transactionCode,
		$transactionCodeType,
		$transactionCodeFamily,
		$transactionCodeOperation,
		$transactionCodeCategory,
		$message,
		bool $hasStructuredMessage,
		$structuredMessageType,
		$structuredMessageFull,
		$structuredMessage,
		$transactionDate,
		$statementSequenceNumber,
		$globalizationCode,
		$sepaDirectDebit )
	{
		$this->sequenceNumber = $sequenceNumber;
		$this->sequenceNumberDetail = $sequenceNumberDetail;
		$this->bankReference = $bankReference;
		$this->amount = $amount;
		$this->valutaDate = $valutaDate;
		$this->transactionCode = $transactionCode;
		$this->transactionCodeType = $transactionCodeType;
		$this->transactionCodeFamily = $transactionCodeFamily;
		$this->transactionCodeOperation = $transactionCodeOperation;
		$this->transactionCodeCategory = $transactionCodeCategory;
		$this->message = $message;
		$this->hasStructuredMessage = $hasStructuredMessage;
		$this->structuredMessageType = $structuredMessageType;
		$this->structuredMessageFull = $structuredMessageFull;
		$this->structuredMessage = $structuredMessage;
		$this->transactionDate = $transactionDate;
		$this->statementSequenceNumber = $statementSequenceNumber;
		$this->globalizationCode = $globalizationCode;
		$this->sepaDirectDebit = $sepaDirectDebit;
	}
	
	
	public function getType(): LineType
	{
		return new LineType(LineType::TransactionPart1);
	}
	
	public function getSequenceNumber()
	{
		return $this->sequenceNumber;
	}
	
	public function getSequenceNumberDetail()
	{
		return $this->sequenceNumberDetail;
	}
	
	public function getBankReference()
	{
		return $this->bankReference;
	}
	
	public function getAmount()
	{
		return $this->amount;
	}
	
	public function getValutaDate()
	{
		return $this->valutaDate;
	}
	
	public function getTransactionCode()
	{
		return $this->transactionCode;
	}
	
	public function getTransactionCodeType()
	{
		return $this->transactionCodeType;
	}
	
	public function getTransactionCodeFamily()
	{
		return $this->transactionCodeFamily;
	}
	
	public function getTransactionCodeOperation()
	{
		return $this->transactionCodeOperation;
	}
	
	public function getTransactionCodeCategory()
	{
		return $this->transactionCodeCategory;
	}
	
	public function getMessage()
	{
		return $this->message;
	}
	
	public function isHasStructuredMessage(): bool
	{
		return $this->hasStructuredMessage;
	}
	
	public function getStructuredMessageType()
	{
		return $this->structuredMessageType;
	}
	
	public function getStructuredMessageFull()
	{
		return $this->structuredMessageFull;
	}
	
	public function getStructuredMessage()
	{
		return $this->structuredMessage;
	}
	
	public function getTransactionDate()
	{
		return $this->transactionDate;
	}
	
	public function getStatementSequenceNumber()
	{
		return $this->statementSequenceNumber;
	}
	
	public function getGlobalizationCode()
	{
		return $this->globalizationCode;
	}
	
	public function getSepaDirectDebit()
	{
		return $this->sepaDirectDebit;
	}
}