<?php

namespace Codelicious\Coda\Lines;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class IdentificationLine implements LineInterface
{
	private $creationDate;
	private $bankIdentificationNumber;
	private $isDuplicate = false;
	private $applicationCode;
	private $fileReference;
	private $accountName;
	private $accountBic;
	private $accountCompanyIdentificationNumber;
	private $externalApplicationCode;
	private $transactionReference;
	private $relatedReference;
	private $versionCode;
	
	public function __construct(
		$creationDate,
		$bankIdentificationNumber,
		$isDuplicate,
		$applicationCode,
		$fileReference,
		$accountName,
		$accountBic,
		$accountCompanyIdentificationNumber,
		$externalApplicationCode,
		$transactionReference,
		$relatedReference,
		$versionCode )
	{
		// TODO: validate
		
		$this->creationDate = $creationDate;
		$this->bankIdentificationNumber = $bankIdentificationNumber;
		$this->isDuplicate = $isDuplicate;
		$this->applicationCode = $applicationCode;
		$this->fileReference = $fileReference;
		$this->accountName = $accountName;
		$this->accountBic = $accountBic;
		$this->accountCompanyIdentificationNumber = $accountCompanyIdentificationNumber;
		$this->externalApplicationCode = $externalApplicationCode;
		$this->transactionReference = $transactionReference;
		$this->relatedReference = $relatedReference;
		$this->versionCode = $versionCode;
	}
	
	public function getType(): LineType
	{
		return new LineType(LineType::Identification);
	}
	
	public function getCreationDate()
	{
		return $this->creationDate;
	}
	
	public function getBankIdentificationNumber()
	{
		return $this->bankIdentificationNumber;
	}
	
	public function isDuplicate(): bool
	{
		return $this->isDuplicate;
	}
	
	public function getApplicationCode()
	{
		return $this->applicationCode;
	}
	
	public function getFileReference()
	{
		return $this->fileReference;
	}
	
	public function getAccountName()
	{
		return $this->accountName;
	}
	
	public function getAccountBic()
	{
		return $this->accountBic;
	}
	
	public function getAccountCompanyIdentificationNumber()
	{
		return $this->accountCompanyIdentificationNumber;
	}
	
	public function getExternalApplicationCode()
	{
		return $this->externalApplicationCode;
	}
	
	public function getTransactionReference()
	{
		return $this->transactionReference;
	}
	
	public function getRelatedReference()
	{
		return $this->relatedReference;
	}
	
	public function getVersionCode()
	{
		return $this->versionCode;
	}
	
}