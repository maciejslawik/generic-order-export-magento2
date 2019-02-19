<?php
declare(strict_types=1);

/**
 * File:ExportOrderMessageInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Api\Amqp;

use Magento\Sales\Api\Data\OrderInterface;

/**
 * Interface ExportOrderMessageInterface
 * @package MSlwk\GenericOrderExport\Api\Amqp
 */
interface ExportOrderMessageInterface
{
    /**
     * @return OrderInterface
     */
    public function getOrder(): OrderInterface;
}
