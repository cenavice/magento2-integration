<?php
namespace Cenavice\Integration\Model\Order;

class Consumer
{
    /**
     * @var \Cenavice\Integration\Logger\Logger
     */
    protected $logger;

    /**
     * Constructor
     *
     * @param \Cenavice\Integration\Logger\Logger $publisher
     */
    public function __construct(
        \Cenavice\Integration\Logger\Logger $logger
    ) {
        $this->logger = $logger;
    }

    public function processMessage($message)
    {
        $this->logger->info($message);
    }
}
