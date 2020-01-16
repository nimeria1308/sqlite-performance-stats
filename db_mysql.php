<?php

require_once('db_common.php');

class MySQLTester extends DBTester
{
    private $mysql_handle;

    function __construct($servername, $username, $password, $database)
    {
        $this->mysql_handle = new mysqli($servername, $username, $password);
        if ($this->mysql_handle->connect_error) {
            throw new Exception("Connection failed: " . $this->mysql_handle->connect_error);
        }

        try {
            // Make sure there's no such database
            $this->query("DROP DATABASE IF EXISTS $database;\n");

            // create the new one
            $this->query("CREATE DATABASE $database;\n");

            // select it
            $this->mysql_handle->select_db($database);
        } catch (Exception $e) {
            $this->close();
            throw $e;
        }
    }

    function get_name()
    {
        return 'MySQL';
    }

    function query($query)
    {
        if ($this->mysql_handle->multi_query($query) !== TRUE) {
            throw new Exception("SQL query failed: " . $this->mysql_handle->error);
        }

        do {
            if ($res = $this->mysql_handle->store_result()) {
                $res->free();
            }
        } while ($this->mysql_handle->more_results() && $this->mysql_handle->next_result());
    }

    function close()
    {
        $this->mysql_handle->close();
    }

    function get_version()
    {
        return $this->mysql_handle->server_info;
    }
}
