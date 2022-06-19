<?php

use Phalcon\Cli\Task;

class MainTask extends Task
{

    public function mainAction()
    {
        $konfig = $this->di->get('config');
        echo "koneksi mysql ke " . $konfig->db->host . " " . $konfig->db->dbname . "\n";
    }

}
