<?php

use Silex\Application;

foreach (glob(__DIR__ . '/startup/*.php') as $file)
    require $file;
