<?php

/*
 * fungsi fungsi statis yang tidak ada koneksi database masukkan sini
 * jangan ada sesi dan lain-lain, buat sedinamic mungkin
 * jangan baca konfig juga disini
 */

function atRunTask($task)
{
    if (PHP_OS == 'WINNT') {
        //echo "winblows\n";
        $lokasi = str_replace('web-root', '', __DIR__);
        $command = "cmd /C php $lokasi/console/run $task";
        $WshShell = new COM("WScript.Shell");
        $telo = $WshShell->Run($command, 0, false);
    } else {
        //echo "linux/mac\n";
        $lokasi = str_replace('web-root', '', __DIR__);
        $command = "php $lokasi/console/run $task > /dev/null 2>/dev/null &";
        //$command = "php $lokasi/console/run $task";
        $telo = shell_exec($command);
    }
    /*echo "dir " . __DIR__ . "\n";
    echo "lokasi $lokasi\n";
    echo "cwd " . getcwd() . "\n";
    echo "command $command\n";
    echo "hasile telo $telo\n";*/
    return $telo;
}

/*
 * clean text
 */
function atCt($text)
{
    $text = preg_replace("/\r|\n/", "", $text);
    $text = trim($text);
    $text = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $text)));
    return $text;
}

function atIsValidDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

function atIsValidDateTime($datetime, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $datetime);
    return $d && $d->format($format) === $datetime;
}

/*
 * zero fill
 */
function atZf($number, $zf)
{
    $format = "%0" . $zf . "d";
    return sprintf($format, $number);
}
