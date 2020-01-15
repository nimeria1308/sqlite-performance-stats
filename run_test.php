<?php

function exception_error_handler($errno, $errstr, $errfile, $errline)
{
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
set_error_handler("exception_error_handler");

require_once('db_common.php');

const NUMBER_OF_TESTS = 16;

if (count($argv) < 2) {
    die('provide db name');
}

require_once("db_$argv[1].php");

try {
    echo $tester->get_name() . " " . $tester->get_version() . "\n";

    for ($i = 1; $i <= NUMBER_OF_TESTS; $i++) {
        $tester->profile_query_from_file("test_$i");
    }
} finally {
    $tester->close();
}
