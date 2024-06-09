<?php
namespace Cenavice\Integration\Logger;

use Monolog\Logger;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Filesystem\DriverInterface;
use Magento\Framework\Logger\Handler\Base;
use Magento\Store\Model\ScopeInterface;

class Handler extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::INFO;

    /**
     * File name
     * @var string
     */
    protected $fileName = '/var/log/cenavice_integration.log';

    /** @var ScopeConfigInterface */
    protected $scopeConfig;

    /**
     * @param DriverInterface $filesystem
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        DriverInterface $filesystem,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($filesystem, null, null);
    }

    /**
     * @param array $record
     * @return bool
     */
    public function isHandling(array $record): bool
    {
        $isDebugEnabled = (bool) $this->scopeConfig->getValue("cenavice_integration/general/debug", ScopeInterface::SCOPE_STORE);
        if ($isDebugEnabled) {
            return true;
        }

        return $record['level'] >= \Monolog\Logger::WARNING;
    }
}
