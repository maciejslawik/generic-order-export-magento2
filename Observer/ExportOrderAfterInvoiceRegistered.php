<?php
declare(strict_types=1);

/**
 * File:ExportOrderAfterInvoiceRegistered.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\Data\OrderInterface;
use MSlwk\GenericOrderExport\Api\OrderExportHandlerInterface;

/**
 * Class ExportOrderAfterInvoiceRegistered
 * @package MSlwk\GenericOrderExport\Observer
 */
class ExportOrderAfterInvoiceRegistered implements ObserverInterface
{
    /**
     * @var OrderExportHandlerInterface
     */
    private $exportHandler;

    /**
     * ExportOrderAfterInvoiceRegistered constructor.
     * @param OrderExportHandlerInterface $exportHandler
     */
    public function __construct(OrderExportHandlerInterface $exportHandler)
    {
        $this->exportHandler = $exportHandler;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var OrderInterface $order */
        $order = $observer->getData('order');
        $this->exportHandler->handleOrderExport($order);
    }
}
