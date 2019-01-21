<?php
/**
 * Created by PhpStorm.
 * User: Jose Arias
 * Date: 5/06/2017
 * Time: 23:40
 */

namespace App\Repositories;
use Illuminate\Support\Facades\Log;

class AsyncOperation extends \Thread {

    public function __construct($arg) {
        $this->arg = $arg;
    }

    public function run() {
        if ($this->arg) {
            $sleep = mt_rand(1, 10);
            printf('%s: %s  -start -sleeps %d' . "\n", date("g:i:sa"), $this->arg, $sleep);
            sleep($sleep);
            printf('%s: %s  -finish' . "\n", date("g:i:sa"), $this->arg);
        }
    }
}
