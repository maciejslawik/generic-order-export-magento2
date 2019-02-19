<?php
declare(strict_types=1);

/**
 * File:ExportOrderMessage.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Model\Amqp;

use Magento\Sales\Api\Data\OrderInterface;
use MSlwk\GenericOrderExport\Api\Amqp\ExportOrderMessageInterface;

/**
 * Class ExportOrderMessage
 * @package MSlwk\GenericOrderExport\Model\Amqp
 */
class ExportOrderMessage implements ExportOrderMessageInterface
{
    /**
     * @var OrderInterface|null
     */
    private $order;

    /**
     * ExportOrderMessage constructor.
     * @param OrderInterface|null $order
     */
    public function __construct(OrderInterface $order)
    {
        $this->order = $order;
    }

    /**
     * @return OrderInterface
     */
    public function getOrder(): OrderInterface
    {
        return $this->order;
    }
}
