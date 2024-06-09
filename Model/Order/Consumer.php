<?php
namespace Cenavice\Integration\Model\Order;

class Consumer
{
    public function processMessage($message)
    {
        echo '<pre>';
        print_r([
            $message
        ]);
        exit;
    }
}
