@echo off
set PHP_PATH=C:\xampp\php
PATH=%PATH%;%PHP_PATH%

echo Generating queries
php generate_queries.php

php run_test.php
