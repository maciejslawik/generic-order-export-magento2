<?php
declare(strict_types=1);

/**
 * File:ExportOrderSubscriber.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Model\Amqp;

use MSlwk\GenericOrderExport\Api\Amqp\ExportOrderMessageInterface;
use MSlwk\GenericOrderExport\Api\Amqp\ExportOrderSubscriberInterface;
use MSlwk\GenericOrderExport\Api\OrderExportServiceInterface;

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
     * ExportOrderSubscriber constructor.
     * @param OrderExportServiceInterface $orderExportService
     */
    public function __construct(OrderExportServiceInterface $orderExportService)
    {
        $this->orderExportService = $orderExportService;
    }

    /**
     * @param ExportOrderMessageInterface $message
     * @return void
     */
    public function processMessage(ExportOrderMessageInterface $message): void
    {
        $this->orderExportService->exportOrder($message->getOrder());
    }
}
