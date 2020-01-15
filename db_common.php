<?php

abstract class DBTester
{
    abstract public function get_name();
    abstract public function close();
    abstract public function get_version();

    abstract protected function query($query);

    function profile_query($test_name, $query)
    {
        $start = microtime(true);
        $this->query($query);
        $end = microtime(true);

        $name = $this->get_name();
        $elapsed = $end - $start;
        $elapsed = number_format($elapsed, 2);
        $number_of_queries = substr_count($query, ';');
        echo "$name:$test_name Running $number_of_queries queries took $elapsed s\n";
    }

    function profile_query_from_file($test_name, $filename = null)
    {
        if (!$filename) {
            $filename = "$test_name.sql";
        }

        $query = file_get_contents($filename);
        $this->profile_query($test_name, $query);
    }
}
