<?php

namespace Codelicious\Coda\Data\Simple\Advanced;

use Codelicious\Coda\Data\Simple\Transaction as SimpleTransaction;

/**
 * @package Codelicious\Coda
 * @author Grummfy<me@grummfy.com>
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Transaction extends SimpleTransaction
{
	public $codeType;
	public $codeFamily;
	public $codeTransaction;
	public $codeCategory;
}
