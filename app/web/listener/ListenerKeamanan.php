<?php

class ListenerKeamanan extends Phalcon\Di\Injectable
{

    public function beforeExecuteRoute(Phalcon\Events\Event $event, Phalcon\Mvc\Dispatcher $dispatcher)
    {

        $kontroler = $dispatcher->getControllerName();
        $aksi = $dispatcher->getActionName();

        //controller action yang gak perlu cek
        $skip_check = [
            'sfg/fgsg',
            'fgtjyj/jhjhk',
            'index/index'
        ];
        if (in_array($kontroler . "/" . $aksi, $skip_check)) {
            return true;
        }

        //controller all action skip check
        $controller_skip_check = [
            'z'
        ];
        if (in_array($kontroler, $controller_skip_check)) {
            return true;
        }

        //tidak punya akses
        $apx_ids = At::getKonfig('apx_ids')->toArray();
        $apx_id = At::getInput('apx_id');
        if (!in_array($apx_id, $apx_ids)) {
            $pesan = "apx_id $apx_id denied on $kontroler/$aksi";
            return $this->responTolak($pesan);
        }

    }

    public function responTolak(string $pesan): bool
    {
        $respon = At::setJsonRespon($pesan, 1);
        $respon->send();
        $this->view->disable();
        return false;
    }
}
