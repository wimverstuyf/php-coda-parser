<?php

namespace Codelicious\Coda\Values;

use function Codelicious\Coda\Helpers\validateStringLength;

class Account
{
	/** @var AccountName */
	private $accountName;
	/** @var AccountDescription */
	private $accountDescription;
	/** @var AccountNumberType */
	private $accountNumberType;
	/** @var AccountNumber */
	private $accountNumber;
	/** @var Currency */
	private $accountCurrency;
	/** @var Country */
	private $accountCountry;
	
	public function __construct(string $accountNumberTypeString, string $accountInfo, string $accountNameInfo)
	{
		validateStringLength($accountInfo, 37, "Account");
		validateStringLength($accountNameInfo, 61, "AccountNameInfo");
		
		list($accountIsIban, $accountNumber, $accountCurrency, $accountCountry) =
			$this->addAccountInfo($accountInfo, $accountNumberTypeString);

		$this->accountNumberType = new AccountNumberType($accountNumberTypeString);
		$this->accountName = new AccountName(mb_substr($accountNameInfo, 0, 26));
		$this->accountDescription = new AccountDescription(mb_substr($accountNameInfo, 26, 35));
		$this->accountNumber = new AccountNumber($accountNumber, $accountIsIban);
		$this->accountCurrency = new Currency($accountCurrency);
		$this->accountCountry = new Country($accountCountry);
	}
	
	private function addAccountInfo(string $accountInfo, string $accountType)
	{
		$accountIsIban = false;
		$accountNumber = "";
		$accountCurrency = "";
		$accountCountry = "";
		
		if ($accountType == "0") {
			$accountNumber = mb_substr($accountInfo, 0, 12);
			$accountCurrency = mb_substr($accountInfo, 13, 3);
			$accountCountry = mb_substr($accountInfo, 17, 2);
		}
		else if ($accountType == "1") {
			$accountNumber = mb_substr($accountInfo, 0, 34);
			$accountCurrency = mb_substr($accountInfo, 34, 3);
		}
		else if ($accountType == "2") {
			$accountIsIban = true;
			$accountNumber = mb_substr($accountInfo, 0, 31);
			$accountCurrency = mb_substr($accountInfo, 34, 3);
			$accountCountry = "BE";
		}
		else if ($accountType == "3") {
			$accountIsIban = true;
			$accountNumber = mb_substr($accountInfo, 0, 34);
			$accountCurrency = mb_substr($accountInfo, 34, 3);
		}
		
		return [$accountIsIban, $accountNumber, $accountCurrency, $accountCountry];
	}
	
	
	public function getName(): AccountName
	{
		return $this->accountName;
	}
	
	public function getDescription(): AccountDescription
	{
		return $this->accountDescription;
	}
	
	public function getNumberType(): AccountNumberType
	{
		return $this->accountNumberType;
	}
	
	public function getNumber(): AccountNumber
	{
		return $this->accountNumber;
	}
	
	public function getCurrency(): Currency
	{
		return $this->accountCurrency;
	}
	
	public function getCountry(): Country
	{
		return $this->accountCountry;
	}
	
}