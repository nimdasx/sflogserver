<?php

use Phalcon\Http\Response;

class At
{

    static function setJsonResponRaw($x)
    {
        $response = new Response();
        $response->setHeader(
            'Access-Control-Allow-Origin',
            '*'
        );
        $response->setJsonContent($x);
        return $response;
    }

    static function setJsonRespon($deskripsi = null, $kode = null, $data = null, $other_data = null, $debug = null)
    {

        $konten_respon = new stdClass();

        //kode
        if ($kode == null) {
            $kode = 200;
        }
        $konten_respon->kode = $kode;

        //deskripsi
        if ($deskripsi == null) {
            $deskripsi = 'Ok';
        }
        $konten_respon->deskripsi = atCt($deskripsi);

        //data
        if ($data) {
            $konten_respon->data = $data;
        }

        //debug
        $di = Phalcon\DI::getDefault();
        $config = $di->get('config');
        if ($config->debug == true and $debug != null) {
            $konten_respon->debug = $debug;
        }

        //other
        if ($other_data != null) {
            $konten_respon->other_data = $other_data;
        }

        $response = new Response();
        $response->setHeader(
            'Access-Control-Allow-Origin',
            '*'
        );
        $response->setJsonContent($konten_respon);

        //set http status code
        /*
         * pateni ndisik 8 oktober 2020 soale dadi error neng client
        if ($kode == 0) {
            $hsc = 200;
        } else {
            $hsc = 400;
        }
        $response->setStatusCode($hsc, $deskripsi);
        */
        //end set http status code

        return $response;
    }

    /*
     * ambil var dari konfigurasi...php
     */
    static function konfigGet($konfige)
    {

        $di = Phalcon\DI::getDefault();
        $config = $di->get('config');
        $isine = $config->get($konfige);

        if (!$isine) {
            //ambil default value jika gak ada di cr_konfig
            $default_konfig_arr = [
                'apx_ids' => [
                    'atgov-api-gundul-pacul',
                    'atogv-api-ringut'
                ]
            ];
            if (key_exists($konfige, $default_konfig_arr)) {
                $isine = $default_konfig_arr[$konfige];
            }
        }

        return $isine;

    }

}