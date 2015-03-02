<?php

spl_autoload_register(
  function ($class) {
      static $classes = NULL;
      static $path = NULL;

      if ($classes === NULL) {
          $classes = array(
           'Codelicious\\Coda\\Parser' => '/Coda/Parser.php',
           'Codelicious\\Coda\\Data\\Simple\\Statement'     => '/Coda/Data/Simple/Statement.php',
           'Codelicious\\Coda\\Data\\Simple\\Transaction'   => '/Coda/Data/Simple/Transaction.php',
           'Codelicious\\Coda\\Data\\Simple\\Account'       => '/Coda/Data/Simple/Account.php',
           'Codelicious\\Coda\\Data\\Raw\\Statement'        => '/Coda/Data/Raw/Statement.php',
           'Codelicious\\Coda\\Data\\Raw\\Identification'   => '/Coda/Data/Raw/Identification.php',
           'Codelicious\\Coda\\Data\\Raw\\Message'          => '/Coda/Data/Raw/Message.php',
           'Codelicious\\Coda\\Data\\Raw\\NewSituation'     => '/Coda/Data/Raw/NewSituation.php',
           'Codelicious\\Coda\\Data\\Raw\\OriginalSituation'=> '/Coda/Data/Raw/OriginalSituation.php',
           'Codelicious\\Coda\\Data\\Raw\\Summary'          => '/Coda/Data/Raw/Summary.php',
           'Codelicious\\Coda\\Data\\Raw\\Transaction'      => '/Coda/Data/Raw/Transaction.php',
           'Codelicious\\Coda\\Data\\Raw\\Transaction21'    => '/Coda/Data/Raw/Transaction21.php',
           'Codelicious\\Coda\\Data\\Raw\\Transaction22'    => '/Coda/Data/Raw/Transaction22.php',
           'Codelicious\\Coda\\Data\\Raw\\Transaction23'    => '/Coda/Data/Raw/Transaction23.php',
           'Codelicious\\Coda\\Data\\Raw\\Transaction31'    => '/Coda/Data/Raw/Transaction31.php',
           'Codelicious\\Coda\\Data\\Raw\\Transaction32'    => '/Coda/Data/Raw/Transaction32.php',
           'Codelicious\\Coda\\Data\\Raw\\Transaction33'    => '/Coda/Data/Raw/Transaction33.php',
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
           'Codelicious\\Coda\\DetailParsers\\TransformToSimple'       => '/Coda/DetailParsers/TransformToSimple.php',
          );
          $path = dirname(__FILE__);
      }

      if (isset($classes[$class])) {
          require $path . $classes[$class];
      }
  }
);
