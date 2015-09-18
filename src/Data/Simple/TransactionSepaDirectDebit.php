<?php

namespace Codelicious\Coda\Data\Simple;

/**
 * @package Codelicious\Coda
 * @author Grummfy <me@grummfy.be>
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class TransactionSepaDirectDebit extends Transaction
{
	public $sddType;
	public $sddScheme;
	public $sddPaid;
	public $sddMandat;
	public $sddCommunication;
}
