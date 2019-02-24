<?php
declare(strict_types=1);

/**
 * File:SampleOrderExportService.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Model;

use Magento\Sales\Api\Data\OrderInterface;
use MSlwk\GenericOrderExport\Api\OrderExportServiceInterface;
use Psr\Log\LoggerInterface;

/**
 * Class SampleOrderExportService
 * @package MSlwk\GenericOrderExport\Model
 */
class SampleOrderExportService implements OrderExportServiceInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SampleOrderExportService constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param OrderInterface $order
     * @return void
     */
    public function exportOrder(OrderInterface $order): void
    {
        $this->logger->debug($order->getIncrementId());
    }
}
