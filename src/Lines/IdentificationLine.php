<?php

namespace Codelicious\Coda\Lines;

use Codelicious\Coda\Values\AccountName;
use Codelicious\Coda\Values\ApplicationCode;
use Codelicious\Coda\Values\BankIdentificationNumber;
use Codelicious\Coda\Values\Bic;
use Codelicious\Coda\Values\CompanyIdentificationNumber;
use Codelicious\Coda\Values\Date;
use Codelicious\Coda\Values\ExternalApplicationCode;
use Codelicious\Coda\Values\FileReference;
use Codelicious\Coda\Values\RelatedReference;
use Codelicious\Coda\Values\TransactionReference;
use Codelicious\Coda\Values\VersionCode;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class IdentificationLine implements LineInterface
{
	/** @var Date */
	private $creationDate;
	/** @var BankIdentificationNumber */
	private $bankIdentificationNumber;
	/** @var bool */
	private $isDuplicate = false;
	/** @var ApplicationCode */
	private $applicationCode;
	/** @var FileReference */
	private $fileReference;
	/** @var AccountName */
	private $accountName;
	/** @var Bic */
	private $accountBic;
	/** @var CompanyIdentificationNumber */
	private $accountCompanyIdentificationNumber;
	/** @var ExternalApplicationCode */
	private $externalApplicationCode;
	/** @var TransactionReference */
	private $transactionReference;
	/** @var RelatedReference */
	private $relatedReference;
	/** @var VersionCode */
	private $versionCode;
	
	public function __construct(
		Date $creationDate,
		BankIdentificationNumber $bankIdentificationNumber,
		bool $isDuplicate,
		ApplicationCode $applicationCode,
		FileReference $fileReference,
		AccountName $accountName,
		Bic $accountBic,
		CompanyIdentificationNumber $accountCompanyIdentificationNumber,
		ExternalApplicationCode $externalApplicationCode,
		TransactionReference $transactionReference,
		RelatedReference $relatedReference,
		VersionCode $versionCode )
	{
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
	
	public function getCreationDate(): Date
	{
		return $this->creationDate;
	}
	
	public function getBankIdentificationNumber(): BankIdentificationNumber
	{
		return $this->bankIdentificationNumber;
	}
	
	public function isDuplicate(): bool
	{
		return $this->isDuplicate;
	}
	
	public function getApplicationCode(): ApplicationCode
	{
		return $this->applicationCode;
	}
	
	public function getFileReference(): FileReference
	{
		return $this->fileReference;
	}
	
	public function getAccountName(): AccountName
	{
		return $this->accountName;
	}
	
	public function getAccountBic(): Bic
	{
		return $this->accountBic;
	}
	
	public function getAccountCompanyIdentificationNumber(): CompanyIdentificationNumber
	{
		return $this->accountCompanyIdentificationNumber;
	}
	
	public function getExternalApplicationCode(): ExternalApplicationCode
	{
		return $this->externalApplicationCode;
	}
	
	public function getTransactionReference(): TransactionReference
	{
		return $this->transactionReference;
	}
	
	public function getRelatedReference(): RelatedReference
	{
		return $this->relatedReference;
	}
	
	public function getVersionCode(): VersionCode
	{
		return $this->versionCode;
	}
	
}