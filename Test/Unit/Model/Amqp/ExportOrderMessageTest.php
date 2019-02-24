<?php
declare(strict_types=1);

/**
 * File:ExportOrderMessageTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Test\Unit\Model\Amqp;

use MSlwk\GenericOrderExport\Model\Amqp\ExportOrderMessage;
use PHPUnit\Framework\TestCase;

/**
 * Class ExportOrderMessageTest
 * @package MSlwk\GenericOrderExport\Test\Unit\Model\Amqp
 */
class ExportOrderMessageTest extends TestCase
{
    /**
     * @test
     */
    public function testOrderId()
    {
        $orderId = '232';
        $exportOrderMessage = new ExportOrderMessage();
        $exportOrderMessage->setOrderId($orderId);

        $this->assertSame($orderId, $exportOrderMessage->getOrderId());
    }
}
