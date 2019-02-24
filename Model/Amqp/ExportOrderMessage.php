<?php
declare(strict_types=1);

/**
 * File:ExportOrderMessage.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Model\Amqp;

use MSlwk\GenericOrderExport\Api\Amqp\ExportOrderMessageInterface;

/**
 * Class ExportOrderMessage
 * @package MSlwk\GenericOrderExport\Model\Amqp
 */
class ExportOrderMessage implements ExportOrderMessageInterface
{
    /**
     * @var string
     */
    private $orderId;

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     * @return void
     */
    public function setOrderId(string $orderId): void
    {
        $this->orderId = $orderId;
    }
}
