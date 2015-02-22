<?php

spl_autoload_register(
  function ($class) {
      static $classes = NULL;
      static $path = NULL;

      if ($classes === NULL) {
          $classes = array(
			     'Codelicious\\Coda\\Parser' => '/Coda/Parser.php',
          );
          $path = dirname(__FILE__);
      }

      if (isset($classes[$class])) {
          require $path . strtolower($classes[$class]);
      }
  }
);
