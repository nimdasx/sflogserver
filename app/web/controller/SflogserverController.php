<?php

use Phalcon\Mvc\Model\Query\Builder;

class SflogserverController extends AController
{

    function insertAction()
    {

        $p = $this->request->getJsonRawBody();

        $la = new Sflogserver();
        $la->apx_id = At::getInput('apx_id');
        $la->activity = $p->activity;
        $la->category = $p->category;
        $la->message = $p->message;
        $la->trace = $p->trace;
        $la->user_agent = $p->user_agent;
        $la->userx = $p->userx;
        $la->ipx = $p->ipx;

        $datetimex = At::getInput('datetimex');
        if (atIsValidDateTime($datetimex)) {
            $la->datetimex = $datetimex;
        } else {
            $la->datetimex = null;
        }

        $la->queryx = $p->queryx;
        $la->datax = $p->datax;

        if (!$la->create()) {
            $this->dm['error'] = $la->getMessages();
            return $this->setJsonRespon('terjadi kesalahan', 1);
        } else {
            return $this->setJsonRespon(null, null, $la);
        }

    }

    public function getAction()
    {
        $p = $this->request->getJsonRawBody();
        if ($p->sflogserver_id == null) {
            return $this->setJsonRespon('sflogserver_id wajib', 1);
        }
        $hs = new Sflogserver();
        $hs->sflogserver_id = $p->sflogserver_id;
        $hs->getData();
        return $this->setJsonRespon($hs->getDeskripsi(), $hs->getKode(), $hs->getData()[0]);
    }

    public function getListAction()
    {
        $p = $this->request->getJsonRawBody();

        //njikuk data
        $hs = new Sflogserver();
        $hs->setParams($p);
        //$hs->limit = '';
        $hs->date_start = $p->date_start;
        $hs->date_end = $p->date_end;
        $hs->getData();

        //ngetung jumlah record terfilter
        $filtered_record = $hs->getDataCount();

        //ngetung jumlah record total
        $hstot = new Sflogserver();
        $total_record = $hstot->getDataCount();

        $other_data = new StdClass();
        $other_data->total_record = $total_record;
        $other_data->filtered_record = $filtered_record;

        return $this->setJsonRespon($hs->getDeskripsi(), $hs->getKode(), $hs->getData(), $other_data);
    }

}