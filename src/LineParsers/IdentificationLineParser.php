<?php

namespace Codelicious\Coda\LineParsers;

use Codelicious\Coda\Lines\IdentificationLine;
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
class IdentificationLineParser implements LineParserInterface
{
	/**
	 * @param string $codaLine
	 * @return IdentificationLine
	 */
	public function parse(string $codaLine)
	{
		return new IdentificationLine(
			new Date(mb_substr($codaLine, 5, 6)),
			new BankIdentificationNumber(mb_substr($codaLine, 11, 3)),
			mb_substr($codaLine, 16, 1) == "D"?true:false,
			new ApplicationCode(mb_substr($codaLine, 14, 2)),
			new FileReference(mb_substr($codaLine, 24, 10)),
			new AccountName(mb_substr($codaLine, 34, 26)),
			new Bic(mb_substr($codaLine, 60, 11)),
			new CompanyIdentificationNumber(mb_substr($codaLine, 71, 11)),
			new ExternalApplicationCode(mb_substr($codaLine, 83, 5)),
			new TransactionReference(mb_substr($codaLine, 88, 16)),
			new RelatedReference(mb_substr($codaLine, 104, 16)),
			new VersionCode(mb_substr($codaLine, 127, 1))
		);
	}

	/**
	 * Check if the parser take into account this type of line
	 *
	 * @param string $codaLine
	 * @return bool
	 */
	public function canAcceptString(string $codaLine)
	{
		return mb_strlen($codaLine) == 128 && mb_substr($codaLine, 0, 1) == "0";
	}
}
