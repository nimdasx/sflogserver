<?php

use Phalcon\Mvc\Controller;

class AController extends Controller
{

    /*
     * debug message
     */
    public $dm = null;

    /*
     * biar dm (debug message gak perlu dideklarasikan tiap manggil fungsion ini
     */
    function setJsonRespon($deskripsi = null, $kode = null, $data = null, $other_data = null)
    {
        return At::setJsonRespon($deskripsi, $kode, $data, $other_data, $this->dm);
    }

    /*
     * auto detect input seko get opo seko json body
     */
    public function getInput($telo)
    {
        //input
        $p = $this->request->getJsonRawBody();
        $pendem = $p->{$telo};
        if ($this->request->has($telo)) {
            $pendem = $this->request->get($telo);
        }
        return $pendem;
    }

}