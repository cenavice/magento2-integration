<?php
namespace Cenavice\Integration\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use function GuzzleHttp\json_encode;

class PublishOrder extends Command
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectmanager;

    /**
     * @var \Magento\Framework\MessageQueue\PublisherInterface
     */
    protected $publisher;

    /**
     * Constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectmanager
     * @param \Magento\Framework\MessageQueue\PublisherInterface $publisher
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectmanager,
        \Magento\Framework\MessageQueue\PublisherInterface $publisher
    ) {
        $this->_objectmanager = $objectmanager;
        $this->publisher = $publisher;
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('cenavice:integration:publish-order');
        $this->setDescription('This is my console command.');

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $state = $this->_objectmanager->get('Magento\Framework\App\State');
        try {
           $state->setAreaCode('adminhtml');            
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
           
        }
        
        $output->writeln('Publishing . . .');

        try {
            $this->publisher->publish('cenavice.order.sync', json_encode(['test' => 'test value']));
            $output->writeln('<info>Success Message.</info>');
        } catch (\Throwable $th) {
            $output->writeln('<error>'.__($th->getMessage()).'</error>');
            return 0;
        }
        
        return 1;
    }
}
