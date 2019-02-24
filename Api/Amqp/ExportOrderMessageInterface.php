<?php
declare(strict_types=1);

/**
 * File:ExportOrderMessageInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Api\Amqp;

/**
 * Interface ExportOrderMessageInterface
 * @package MSlwk\GenericOrderExport\Api\Amqp
 */
interface ExportOrderMessageInterface
{
    /**
     * @return string
     */
    public function getOrderId(): string;

    /**
     * @param string $orderId
     * @return void
     */
    public function setOrderId(string $orderId): void;
}
