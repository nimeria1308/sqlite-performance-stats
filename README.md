# Compare DB performance of SQLite vs MySQL

This is a sample PHP script that compares the local performance of SQLite and MySQL.

This is based on the queries created for the
[speed comparison for SQLite][1]. The obtained data there was
outdated, thus this script rerun it on top of the newest versions.

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

### Sample output

Some of the details have been removed for privacy.

    C:\sqlite-performance-stats>run_test.bat

    Obtaining system information

    OS Name:                   Microsoft Windows 10 Education
    OS Version:                10.0.18362 N/A Build 18362
    OS Manufacturer:           Microsoft Corporation
    OS Configuration:          Standalone Workstation
    OS Build Type:             Multiprocessor Free
    Original Install Date:     13/08/2019, 09:27:35
    System Boot Time:          16/01/2020, 01:12:03
    System Manufacturer:       LENOVO
    System Model:              81NE
    System Type:               x64-based PC
    Processor(s):              1 Processor(s) Installed.
                               [01]: Intel64 Family 6 Model 142 Stepping    11 GenuineIntel ~1792 Mhz
    BIOS Version:              LENOVO APCN29WW, 15/05/2019
    Total Physical Memory:     8,038 MB
    Available Physical Memory: 4,971 MB
    Virtual Memory: Max Size:  13,158 MB
    Virtual Memory: Available: 9,194 MB
    Virtual Memory: In Use:    3,964 MB

    Hyper-V Requirements:      VM Monitor Mode Extensions: Yes
                               Virtualization Enabled In Firmware: Yes
                               Second Level Address Translation: Yes
                               Data Execution Prevention Available: Yes

    Generating queries

    SQLite 3.28.0
    SQLite:test_1 Running 1001 queries took 5.09 s
    SQLite:test_2 Running 25003 queries took 0.05 s
    SQLite:test_3 Running 25004 queries took 0.42 s
    SQLite:test_4 Running 102 queries took 0.12 s
    SQLite:test_5 Running 102 queries took 0.42 s
    SQLite:test_6 Running 2 queries took 0.03 s
    SQLite:test_7 Running 5002 queries took 0.03 s
    SQLite:test_8 Running 1002 queries took 0.06 s
    SQLite:test_9 Running 25002 queries took 0.12 s
    SQLite:test_10 Running 25002 queries took 0.09 s
    SQLite:test_11 Running 4 queries took 0.06 s
    SQLite:test_12 Running 1 queries took 0.06 s
    SQLite:test_13 Running 1 queries took 0.05 s
    SQLite:test_14 Running 1 queries took 0.04 s
    SQLite:test_15 Running 12003 queries took 0.03 s
    SQLite:test_16 Running 3 queries took 0.02 s

    MySQL 5.5.5-10.4.8-MariaDB
    MySQL:test_1 Running 1001 queries took 1.57 s
    MySQL:test_2 Running 25003 queries took 42.72 s
    MySQL:test_3 Running 25004 queries took 44.43 s
    MySQL:test_4 Running 102 queries took 0.52 s
    MySQL:test_5 Running 102 queries took 1.22 s
    MySQL:test_6 Running 2 queries took 0.19 s
    MySQL:test_7 Running 5002 queries took 0.31 s
    MySQL:test_8 Running 1002 queries took 0.25 s
    MySQL:test_9 Running 25002 queries took 0.94 s
    MySQL:test_10 Running 25002 queries took 0.96 s
    MySQL:test_11 Running 4 queries took 0.35 s
    MySQL:test_12 Running 1 queries took 0.24 s
    MySQL:test_13 Running 1 queries took 0.21 s
    MySQL:test_14 Running 1 queries took 0.46 s
    MySQL:test_15 Running 12003 queries took 0.28 s
    MySQL:test_16 Running 3 queries took 0.06 s

[1]: https://www.sqlite.org/speed.html
