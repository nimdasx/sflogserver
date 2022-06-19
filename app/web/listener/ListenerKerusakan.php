<?php

class ListenerKerusakan extends Phalcon\Di\Injectable
{
    public function beforeException(Phalcon\Events\Event $event, Phalcon\Mvc\Dispatcher $dispatcher, Exception $ex)
    {

        //kalau error maka disable view
        $this->view->disable();

        $error =
            $ex->getMessage() . PHP_EOL .
            $ex->getTraceAsString() . PHP_EOL .
            implode($this->request->getQuery());

        //log php
        error_log($error);

        switch ($ex->getCode()) {
            case Phalcon\Dispatcher\Exception::EXCEPTION_HANDLER_NOT_FOUND:
                $telo = "Sorry (handler) " . $this->request->getQuery()['_url'] . " not found";
                break;
            case Phalcon\Dispatcher\Exception::EXCEPTION_ACTION_NOT_FOUND:
                $telo = "Sorry (action) " . $this->request->getQuery()['_url'] . " not found";
                break;
            default:
                $telo = "Sorry an error occurred";
                break;
        }

        $debugx = [
            'err_message' => $ex->getMessage(),
            'err_trace' => $ex->getTraceAsString(),
            'query' => $this->request->getQuery()
        ];
        $respon = At::setJsonRespon($telo, 1, null, null, $debugx);
        $respon->send();
        exit;
        //return false;

    }
}