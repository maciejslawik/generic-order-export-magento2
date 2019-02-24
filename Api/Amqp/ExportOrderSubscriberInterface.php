<?php
declare(strict_types=1);

/**
 * File:ExportOrderSubscriberInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Api\Amqp;


/**
 * Interface ExportOrderSubscriberInterface
 * @package MSlwk\GenericOrderExport\Api\Amqp
 */
interface ExportOrderSubscriberInterface
{
    /**
     * @param ExportOrderMessageInterface $message
     * @return void
     */
    public function processMessage(ExportOrderMessageInterface $message): void;
}
