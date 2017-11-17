<?php

namespace Codelicious\Coda\Lines;

use Codelicious\Coda\Enum;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class LineType extends Enum
{
	const __default = self::Unknown;
	
	const Unknown = -1;
	const Identification = 00;
	const InitialState = 10;
	const TransactionPart1 = 21;
	const TransactionPart2 = 22;
	const TransactionPart3 = 23;
	const InformationPart1 = 31;
	const InformationPart2 = 32;
	const InformationPart3 = 33;
	const Message = 40;
	const NewState = 80;
	const EndSummary = 90;
}