<?php

require_once('db_common.php');

class SQLite3Tester extends DBTester
{

    private $sqlite_handle;

    function __construct($db_filename)
    {
        if (file_exists($db_filename)) {
            unlink($db_filename);
        }

        $this->sqlite_handle = new SQLite3($db_filename);
    }

    function get_name()
    {
        return 'SQLite';
    }

    function query($query)
    {
        $this->sqlite_handle->exec($query);
    }

    function close()
    {
        $this->sqlite_handle->close();
    }

    function get_version()
    {
        return $this->sqlite_handle->version()["versionString"];
    }
}

const DB_FILENAME = "sqlite.db";

$tester = new SQLite3Tester(DB_FILENAME);
