# Compare DB performance of SQLite vs MySQL

This is a sample PHP script that compares the local performance of SQLite and MySQL.

## Requiremets

This requires the following PHP extensions:

* sqlite3
* mysqli
* intl

## Running

To run the test simply run `run_test.php`.

## Running under Windows on XAMPP

If you have a XAMPP installation on Windows machine,
there is a small batch script to get you goind.

Simply run `run_test.bat` and it will do it for you.

### Required setup

#### PHP Folder

By default it is configured to find php.exe in `C:\xampp\php`.
If you need to change this, alter `PHP_PATH` in `run_test.bat`.

#### PHP extensions

By default, not all extensions are enabled on XAMPP.
Make sure the following lines are not commented out in `C:\xampp\php\php.ini`:

* `extension=sqlite3`
* `extension=mysqli`
* `extension=intl`

#### MySQL Packet Configuration

By default, the maximum package size on XAMPP is 1MB.
This would be too small for this test. Set it to 100MB
in `C:\xampp\mysql\bin\my.ini`:

    max_allowed_packet=100M
