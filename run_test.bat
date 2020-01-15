@echo off
set PHP_PATH=C:\xampp\php
PATH=%PATH%;%PHP_PATH%

echo Generating queries
php generate_queries.php

echo Profiling SQLite
php run_test.php sqlite
