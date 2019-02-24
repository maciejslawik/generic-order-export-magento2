<?php
declare(strict_types=1);

/**
 * File:OrderExportHandler.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Model;

use Exception;
use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Sales\Api\Data\OrderInterface;
use MSlwk\GenericOrderExport\Api\Amqp\ExportOrderMessageInterface;
use MSlwk\GenericOrderExport\Api\Amqp\ExportOrderMessageInterfaceFactory;
use MSlwk\GenericOrderExport\Api\ConfigProviderInterface;
use MSlwk\GenericOrderExport\Api\OrderExportHandlerInterface;
use MSlwk\GenericOrderExport\Api\OrderExportServiceInterface;
use Psr\Log\LoggerInterface;

/**
 * Class OrderExportHandler
 * @package MSlwk\GenericOrderExport\Model
 */
class OrderExportHandler implements OrderExportHandlerInterface
{
    /**
     * @var string
     */
    private const TOPIC_ORDER_EXPORT = 'exportNewOrdersTopic';

    /**
     * @var ConfigProviderInterface
     */
    private $configProvider;

    /**
     * @var ExportOrderMessageInterfaceFactory
     */
    private $exportOrderMessageFactory;

    /**
     * @var PublisherInterface
     */
    private $publisher;

    /**
     * @var OrderExportServiceInterface
     */
    private $orderExportService;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ExportOrderAfterPlace constructor.
     * @param ConfigProviderInterface $configProvider
     * @param ExportOrderMessageInterfaceFactory $exportOrderMessageFactory
     * @param PublisherInterface $publisher
     * @param OrderExportServiceInterface $orderExportService
     * @param LoggerInterface $logger
     */
    public function __construct(
        ConfigProviderInterface $configProvider,
        ExportOrderMessageInterfaceFactory $exportOrderMessageFactory,
        PublisherInterface $publisher,
        OrderExportServiceInterface $orderExportService,
        LoggerInterface $logger
    ) {
        $this->configProvider = $configProvider;
        $this->exportOrderMessageFactory = $exportOrderMessageFactory;
        $this->publisher = $publisher;
        $this->orderExportService = $orderExportService;
        $this->logger = $logger;
    }

    /**
     * @param OrderInterface $order
     * @return void
     */
    public function handleOrderExport(OrderInterface $order): void
    {
        try {
            if ($this->configProvider->isExportAsync()) {
                /** @var ExportOrderMessageInterface $message */
                $message = $this->exportOrderMessageFactory->create();
                $message->setOrderId((string)$order->getEntityId());
                $this->publisher->publish(self::TOPIC_ORDER_EXPORT, $message);
            } else {
                $this->orderExportService->exportOrder($order);
            }
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), ['order_id' => $order->getEntityId()]);
        }
    }
}
