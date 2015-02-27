<?php

spl_autoload_register(
  function ($class) {
      static $classes = NULL;
      static $path = NULL;

      if ($classes === NULL) {
          $classes = array(
			     'Codelicious\\Coda\\Parser' => '/Coda/Parser.php',
           'Codelicious\\Coda\\TransformToSimplified' => '/Coda/TransformToSimplified.php',
           'Codelicious\\Coda\\SimplifiedData\\AccountTransactions' => '/Coda/SimplifiedData/AccountTransactions.php',
           'Codelicious\\Coda\\SimplifiedData\\Transaction'         => '/Coda/SimplifiedData/Transaction.php',
           'Codelicious\\Coda\\SimplifiedData\\Account'             => '/Coda/SimplifiedData/Account.php',
           'Codelicious\\Coda\\Data\\AccountTransactions' => '/Coda/Data/AccountTransactions.php',
           'Codelicious\\Coda\\Data\\Identification'      => '/Coda/Data/Identification.php',
           'Codelicious\\Coda\\Data\\Message'             => '/Coda/Data/Message.php',
           'Codelicious\\Coda\\Data\\NewSituation'        => '/Coda/Data/NewSituation.php',
           'Codelicious\\Coda\\Data\\OriginalSituation'   => '/Coda/Data/OriginalSituation.php',
           'Codelicious\\Coda\\Data\\Summary'             => '/Coda/Data/Summary.php',
           'Codelicious\\Coda\\Data\\Transaction'         => '/Coda/Data/Transaction.php',
           'Codelicious\\Coda\\Data\\Transaction21'       => '/Coda/Data/Transaction21.php',
           'Codelicious\\Coda\\Data\\Transaction22'       => '/Coda/Data/Transaction22.php',
           'Codelicious\\Coda\\Data\\Transaction23'       => '/Coda/Data/Transaction23.php',
           'Codelicious\\Coda\\Data\\Transaction31'       => '/Coda/Data/Transaction31.php',
           'Codelicious\\Coda\\Data\\Transaction32'       => '/Coda/Data/Transaction32.php',
           'Codelicious\\Coda\\Data\\Transaction33'       => '/Coda/Data/Transaction33.php',
           'Codelicious\\Coda\\DetailParsers\\IdentificationParser'    => '/Coda/DetailParsers/IdentificationParser.php',
           'Codelicious\\Coda\\DetailParsers\\MessageParser'           => '/Coda/DetailParsers/MessageParser.php',
           'Codelicious\\Coda\\DetailParsers\\NewSituationParser'      => '/Coda/DetailParsers/NewSituationParser.php',
           'Codelicious\\Coda\\DetailParsers\\OriginalSituationParser' => '/Coda/DetailParsers/OriginalSituationParser.php',
           'Codelicious\\Coda\\DetailParsers\\SummaryParser'           => '/Coda/DetailParsers/SummaryParser.php',
           'Codelicious\\Coda\\DetailParsers\\Transaction21Parser'     => '/Coda/DetailParsers/Transaction21Parser.php',
           'Codelicious\\Coda\\DetailParsers\\Transaction22Parser'     => '/Coda/DetailParsers/Transaction22Parser.php',
           'Codelicious\\Coda\\DetailParsers\\Transaction23Parser'     => '/Coda/DetailParsers/Transaction23Parser.php',
           'Codelicious\\Coda\\DetailParsers\\Transaction31Parser'     => '/Coda/DetailParsers/Transaction31Parser.php',
           'Codelicious\\Coda\\DetailParsers\\Transaction32Parser'     => '/Coda/DetailParsers/Transaction32Parser.php',
           'Codelicious\\Coda\\DetailParsers\\Transaction33Parser'     => '/Coda/DetailParsers/Transaction33Parser.php',
          );
          $path = dirname(__FILE__);
      }

      if (isset($classes[$class])) {
          require $path . $classes[$class];
      }
  }
);
