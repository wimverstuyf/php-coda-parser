<?php

spl_autoload_register(
  function ($class) {
      static $classes = NULL;
      static $path = NULL;

      if ($classes === NULL) {
          $classes = array(
           'Codelicious\\Coda\\Parser' => '/Parser.php',
           'Codelicious\\Coda\\Data\\Simple\\Statement'     => '/Data/Simple/Statement.php',
           'Codelicious\\Coda\\Data\\Simple\\Transaction'   => '/Data/Simple/Transaction.php',
           'Codelicious\\Coda\\Data\\Simple\\Account'       => '/Data/Simple/Account.php',
           'Codelicious\\Coda\\Data\\Raw\\Statement'        => '/Data/Raw/Statement.php',
           'Codelicious\\Coda\\Data\\Raw\\Identification'   => '/Data/Raw/Identification.php',
           'Codelicious\\Coda\\Data\\Raw\\Message'          => '/Data/Raw/Message.php',
           'Codelicious\\Coda\\Data\\Raw\\NewSituation'     => '/Data/Raw/NewSituation.php',
           'Codelicious\\Coda\\Data\\Raw\\OriginalSituation'=> '/Data/Raw/OriginalSituation.php',
           'Codelicious\\Coda\\Data\\Raw\\Summary'          => '/Data/Raw/Summary.php',
           'Codelicious\\Coda\\Data\\Raw\\Transaction'      => '/Data/Raw/Transaction.php',
           'Codelicious\\Coda\\Data\\Raw\\Transaction21'    => '/Data/Raw/Transaction21.php',
           'Codelicious\\Coda\\Data\\Raw\\Transaction22'    => '/Data/Raw/Transaction22.php',
           'Codelicious\\Coda\\Data\\Raw\\Transaction23'    => '/Data/Raw/Transaction23.php',
           'Codelicious\\Coda\\Data\\Raw\\Transaction31'    => '/Data/Raw/Transaction31.php',
           'Codelicious\\Coda\\Data\\Raw\\Transaction32'    => '/Data/Raw/Transaction32.php',
           'Codelicious\\Coda\\Data\\Raw\\Transaction33'    => '/Data/Raw/Transaction33.php',
           'Codelicious\\Coda\\DetailParsers\\IdentificationParser'    => '/DetailParsers/IdentificationParser.php',
           'Codelicious\\Coda\\DetailParsers\\MessageParser'           => '/DetailParsers/MessageParser.php',
           'Codelicious\\Coda\\DetailParsers\\NewSituationParser'      => '/DetailParsers/NewSituationParser.php',
           'Codelicious\\Coda\\DetailParsers\\OriginalSituationParser' => '/DetailParsers/OriginalSituationParser.php',
           'Codelicious\\Coda\\DetailParsers\\SummaryParser'           => '/DetailParsers/SummaryParser.php',
           'Codelicious\\Coda\\DetailParsers\\Transaction21Parser'     => '/DetailParsers/Transaction21Parser.php',
           'Codelicious\\Coda\\DetailParsers\\Transaction22Parser'     => '/DetailParsers/Transaction22Parser.php',
           'Codelicious\\Coda\\DetailParsers\\Transaction23Parser'     => '/DetailParsers/Transaction23Parser.php',
           'Codelicious\\Coda\\DetailParsers\\Transaction31Parser'     => '/DetailParsers/Transaction31Parser.php',
           'Codelicious\\Coda\\DetailParsers\\Transaction32Parser'     => '/DetailParsers/Transaction32Parser.php',
           'Codelicious\\Coda\\DetailParsers\\Transaction33Parser'     => '/DetailParsers/Transaction33Parser.php',
           'Codelicious\\Coda\\DetailParsers\\TransformToSimple'       => '/DetailParsers/TransformToSimple.php',
          );
          $path = dirname(__FILE__);
      }

      if (isset($classes[$class])) {
          require $path . $classes[$class];
      }
  }
);
