<?php
declare(strict_types=1);

/**
 * File:ExportOrderSubscriber.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Model\Amqp;

use Exception;
use Magento\Sales\Api\OrderRepositoryInterface;
use MSlwk\GenericOrderExport\Api\Amqp\ExportOrderMessageInterface;
use MSlwk\GenericOrderExport\Api\Amqp\ExportOrderSubscriberInterface;
use MSlwk\GenericOrderExport\Api\OrderExportServiceInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ExportOrderSubscriber
 * @package MSlwk\GenericOrderExport\Model\Amqp
 */
class ExportOrderSubscriber implements ExportOrderSubscriberInterface
{
    /**
     * @var OrderExportServiceInterface
     */
    private $orderExportService;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ExportOrderSubscriber constructor.
     * @param OrderExportServiceInterface $orderExportService
     * @param OrderRepositoryInterface $orderRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        OrderExportServiceInterface $orderExportService,
        OrderRepositoryInterface $orderRepository,
        LoggerInterface $logger
    ) {
        $this->orderExportService = $orderExportService;
        $this->orderRepository = $orderRepository;
        $this->logger = $logger;
    }

    /**
     * @param ExportOrderMessageInterface $message
     * @return void
     */
    public function processMessage(ExportOrderMessageInterface $message): void
    {
        try {
            $order = $this->orderRepository->get((int)$message->getOrderId());
            $this->orderExportService->exportOrder($order);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), ['order_id' => $message->getOrderId()]);
        }
    }
}
