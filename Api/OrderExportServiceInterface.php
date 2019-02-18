<?php
declare(strict_types=1);

/**
 * File:OrderExportServiceInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Api;

use Magento\Sales\Api\Data\OrderInterface;

/**
 * Interface OrderExportServiceInterface
 * @package MSlwk\GenericOrderExport\Api
 */
interface OrderExportServiceInterface
{
    /**
     * @param OrderInterface $order
     * @return void
     */
    public function exportOrder(OrderInterface $order): void;
}
