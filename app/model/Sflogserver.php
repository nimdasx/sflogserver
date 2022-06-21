<?php

use Phalcon\Mvc\Model\Query\Builder;

class Sflogserver extends AModel
{

    public $sflogserver_id = null;
    public $date_start = null;
    public $date_end = null;
    public $apx_id = null;
    public $app_id = null;
    public $db_name = null;
    public $db_ip = null;
    public $activity = null;
    public $category = null;
    public $message = null;
    public $trace = null;
    public $user_agent = null;
    public $userx = null;
    public $ipx = null;
    public $datetimex = null;
    public $queryx = null;
    public $datax = null;

    static function getDataById($id)
    {
        if ($id == '') {
            return false;
        }
        $r = new Sflogserver;
        $r->sflogserver_id = $id;
        $r->getData();
        return $r->getData()[0];
    }

    public function getDataCount()
    {
        $b = $this->builderWhere();
        $b
            ->columns([
                'kount' => 'count(*)',
            ])
            ->from("Sflogserver");
        $r = $b->getQuery()->getSingleResult();
        return $r->kount;
    }

    public function getData()
    {

        $b = $this->builderWhere();
        $b
            ->columns([
                'Sflogserver.sflogserver_id',
                'Sflogserver.apx_id',
                'Sflogserver.app_id',
                'Sflogserver.db_name',
                'Sflogserver.db_ip',
                'Sflogserver.activity',
                'Sflogserver.category',
                'Sflogserver.message',
                'Sflogserver.trace',
                'Sflogserver.user_agent',
                'Sflogserver.userx',
                'Sflogserver.ipx',
                'Sflogserver.datetimex',
                'Sflogserver.queryx',
                'Sflogserver.datax',
                'Sflogserver.i_ip',
                'Sflogserver.i_datetime',
                'Sflogserver.i_query'
            ])
            ->from("Sflogserver");
        if ($this->limit != '') {
            $b->limit($this->limit);
        }
        $b->offset($this->offset);
        if ($this->order_by != '') {
            $b->orderBy($this->order_by);
        } else {
            $b->orderBy('Sflogserver.i_datetime DESC');
        }
        $rs = $b->getQuery()->execute();

        //lempar kalo gak ada data
        if (count($rs) < 1) {
            $this->setDeskripsi("data tidak ditemukan");
            $this->setKode(400);
            return false;
        }

        $i = $this->offset;
        foreach ($rs as $r) {
            $i++;
            $rx = new stdClass();
            $rx->nomor = $i;

            //yang auto
            foreach ($r as $key => $value) {
                $rx->{$key} = $r->{$key};
            }

            //tambahakan sini kalo ada yang manual

            $rsx[] = $rx;
            unset($rx);
        }
        $this->setData($rsx);
        return $rsx;

    }

    private function builderWhere(): Builder
    {
        $b = new Builder();
        if ($this->sflogserver_id != '') {
            $b->andWhere('Sflogserver.sflogserver_id=:pk:', ['pk' => $this->sflogserver_id]);
        }
        if ($this->search_str != '') {
            $b->andWhere('
            Sflogserver.activity like :q:
            ',
                ['q' => '%' . $this->search_str . '%']);
        }
        if ($this->date_start != '' and $this->date_end != '') {
            $b->andWhere('date(Sflogserver.i_datetime) >= :tgl_mulai: and date(Sflogserver.i_datetime)<=:tgl_akhir:', [
                'tgl_mulai' => $this->date_start,
                'tgl_akhir' => $this->date_end
            ]);
        }
        return $b;
    }

}