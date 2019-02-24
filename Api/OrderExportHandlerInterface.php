<?php
declare(strict_types=1);

/**
 * File:OrderExportHandlerInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Api;

use Magento\Sales\Api\Data\OrderInterface;

/**
 * Interface OrderExportHandlerInterface
 * @package MSlwk\GenericOrderExport\Api
 */
interface OrderExportHandlerInterface
{
    /**
     * @param OrderInterface $order
     * @return void
     */
    public function handleOrderExport(OrderInterface $order): void;
}
