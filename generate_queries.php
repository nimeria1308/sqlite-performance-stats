<?php

function generate_queries($query_generator, ...$args)
{
    $filename = "$query_generator.sql";
    $f = fopen($filename, "w") or die("Unable to open file" . $filename);
    try {
        $query_generator($f, ...$args);
    } finally {
        fclose($f);
    }
}

function generate_rows($table, $rows, $max, $seed = null)
{
    srand($seed);

    $fmt = new NumberFormatter("en", NumberFormatter::SPELLOUT);

    for ($row = 1; $row <= $rows; $row++) {
        $r = rand(0, $max);
        $s = $fmt->format($r);
        yield "INSERT INTO $table VALUES($row, $r,'$s');\n";
    }
}

function generate_selects($table, $count, $b_offset = 0)
{
    for ($i = 0; $i < $count; $i++) {
        $b_min = $i * 100;
        $b_max = $b_min + $b_offset;
        yield "SELECT count(*), avg(b) FROM $table WHERE b>=$b_min AND b<$b_max;\n";
    }
}

function test_1($f, $rows, $str_length)
{
    fwrite($f, "CREATE TABLE t1(a INTEGER, b INTEGER, c VARCHAR($str_length));\n");
    foreach (generate_rows('t1', $rows, 100000, 0) as $row) {
        fwrite($f, $row);
    }
}

function test_2($f, $rows, $str_length)
{
    fwrite($f, "BEGIN;\n");
    fwrite($f, "CREATE TABLE t2(a INTEGER, b INTEGER, c VARCHAR($str_length));\n");
    foreach (generate_rows('t2', $rows, 500000, 0) as $row) {
        fwrite($f, $row);
    }
    fwrite($f, "COMMIT;\n");
}

function test_3($f, $rows, $str_length)
{
    fwrite($f, "BEGIN;\n");
    fwrite($f, "CREATE TABLE t3(a INTEGER, b INTEGER, c VARCHAR($str_length));\n");
    fwrite($f, "CREATE INDEX i3 ON t3(c);\n");
    foreach (generate_rows('t3', $rows, 500000, 0) as $row) {
        fwrite($f, $row);
    }
    fwrite($f, "COMMIT;\n");
}

function test_4($f, $count)
{
    fwrite($f, "BEGIN;\n");
    foreach (generate_selects('t2', $count, 1000) as $select) {
        fwrite($f, $select);
    }
    fwrite($f, "COMMIT;\n");
}

function test_5($f, $count)
{
    $fmt = new NumberFormatter("en", NumberFormatter::SPELLOUT);

    fwrite($f, "BEGIN;\n");

    for ($i = 1; $i <= $count; $i++) {
        $s = $fmt->format($i);
        fwrite($f, "SELECT count(*), avg(b) FROM t2 WHERE c LIKE '%$s%';\n");
    }

    fwrite($f, "COMMIT;\n");
}

function test_6($f)
{
    fwrite($f, "CREATE INDEX i2a ON t2(a);\n");
    fwrite($f, "CREATE INDEX i2b ON t2(b);\n");
}

function test_7($f, $count)
{
    fwrite($f, "BEGIN;\n");
    foreach (generate_selects('t2', $count, 100) as $select) {
        fwrite($f, $select);
    }
    fwrite($f, "COMMIT;\n");
}

function test_8($f, $count)
{
    fwrite($f, "BEGIN;\n");

    for ($i = 0; $i < $count; $i++) {
        $min_a = $i * 10;
        $max_a = ($i + 1) * 10;
        fwrite($f, "UPDATE t1 SET b=b*2 WHERE a>=$min_a AND a<$max_a;\n");
    }

    fwrite($f, "COMMIT;\n");
}

function test_9($f, $count)
{
    fwrite($f, "BEGIN;\n");
    srand(1);

    for ($a = 0; $a < $count; $a++) {
        $b = rand(0, 500000);
        fwrite($f, "UPDATE t2 SET b=$b WHERE a=$a;\n");
    }

    fwrite($f, "COMMIT;\n");
}

function test_10($f, $count)
{
    $fmt = new NumberFormatter("en", NumberFormatter::SPELLOUT);

    fwrite($f, "BEGIN;\n");
    srand(1);

    for ($a = 0; $a < $count; $a++) {
        $r = rand(0, 500000);
        $c = $fmt->format($r);
        fwrite($f, "UPDATE t2 SET c='$c' WHERE a=$a;\n");
    }

    fwrite($f, "COMMIT;\n");
}

function test_11($f)
{
    fwrite($f, "BEGIN;\n");
    fwrite($f, "INSERT INTO t1 SELECT b,a,c FROM t2;\n");
    fwrite($f, "INSERT INTO t2 SELECT b,a,c FROM t1;\n");
    fwrite($f, "COMMIT;\n");
}

function test_12($f)
{
    fwrite($f, "DELETE FROM t2 WHERE c LIKE '%fifty%';\n");
}

function test_13($f)
{
    fwrite($f, "DELETE FROM t2 WHERE a>10 AND a<20000;\n");
}

function test_14($f)
{
    fwrite($f, "INSERT INTO t2 SELECT * FROM t1;\n");
}

function test_15($f, $rows)
{
    fwrite($f, "BEGIN;\n");
    fwrite($f, "DELETE FROM t1;\n");
    foreach (generate_rows('t1', $rows, 100000, 1) as $row) {
        fwrite($f, $row);
    }
    fwrite($f, "COMMIT;\n");
}

function test_16($f)
{
    fwrite($f, "DROP TABLE t1;\n");
    fwrite($f, "DROP TABLE t2;\n");
    fwrite($f, "DROP TABLE t3;\n");
}

generate_queries('test_1', 10, 100);    // 1000, 100
generate_queries('test_2', 10, 100);    // 25000, 100
generate_queries('test_3', 10, 100);    // 24000, 100
generate_queries('test_4', 10);         // 100
generate_queries('test_5', 10);         // 100
generate_queries('test_6');
generate_queries('test_7', 10);         // 5000
generate_queries('test_8', 10);         // 1000
generate_queries('test_9', 10);         // 25000
generate_queries('test_10', 10);        // 25000
generate_queries('test_11');
generate_queries('test_12');
generate_queries('test_13');
generate_queries('test_14');
generate_queries('test_15', 10);        // 12000
generate_queries('test_16');
