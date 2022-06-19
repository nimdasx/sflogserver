<?php

use Phalcon\Mvc\Model;

class AModel extends Model
{

    public $order_by = null;
    public $limit = null;
    public $offset = 0;
    public $search_str = null;

    public $dm = null;
    private $data = null;
    private $deskripsi = null;
    private $kode = null;

    /*
     * dinggo set query
     */
    public function setParams($p)
    {
        $this->limit = (trim($p->limit != '')) ? $p->limit : '100';
        $this->offset = (trim($p->offset != '')) ? $p->offset : 0;
        $this->search_str = (trim($p->search_str != '')) ? $p->search_str : '';
        $this->order_by = (trim($p->order_by) != '') ? $p->order_by : '';
    }

    /* debug message */
    function getDm()
    {
        return $this->dm;
    }

    /* data */
    function getData()
    {
        return $this->data;
    }

    function setData($datax)
    {
        $this->data = $datax;
    }

    /* pesan */
    function getDeskripsi()
    {
        return $this->deskripsi;
    }

    function setDeskripsi($deskripsix)
    {
        $this->deskripsi = $deskripsix;
    }

    /* kode error */
    function getKode()
    {
        return $this->kode;
    }

    function setKode($kode)
    {
        $this->kode = $kode;
    }

    function beforeValidationOnCreate()
    {

        //set primary key
        $primary_keys = $this->getModelsMetaData()->getPrimaryKeyAttributes($this);
        $pk = $primary_keys[0];
        if (!@$this->$pk) {
            $random = new Phalcon\Security\Random();
            $this->$pk = $random->uuid();
        }

        $request = new \Phalcon\Http\Request();

        //set ip
        $ip = $request->getClientAddress(true);
        $this->i_ip = $ip;
        $this->u_ip = $ip;

        //set time
        $time = date("Y-m-d H:i:s");
        $this->i_datetime = $time;
        $this->u_datetime = $time;

        //set user agent
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $this->i_user_agent = $user_agent;
        $this->u_user_agent = $user_agent;

        //set query
        $query = substr($this->getQuery(), 0, 500);
        $this->i_query = $query;
        $this->u_query = $query;

    }

    function beforeValidationOnUpdate()
    {

        $request = new \Phalcon\Http\Request();

        //set ip
        $this->u_ip = $request->getClientAddress(true);

        //set time
        $this->u_datetime = date("Y-m-d H:i:s");

        //set query
        $this->u_query = $this->getQuery();
    }

    private function getQuery()
    {
        $query = null;
        if (APP_TYPE == 'WEB') {
            $di = Phalcon\DI::getDefault();
            $query = $di->get('request')->getQuery();
            $query = http_build_query($query);
            $query = str_replace("%2F", "/", $query);
            $query = str_replace("_url=/", "", $query);
        }
        return $query;
    }
}