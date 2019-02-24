<?php
declare(strict_types=1);

/**
 * File:ExportOrderAfterInvoiceRegisteredTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Test\Unit\Observer;

use MSlwk\GenericOrderExport\Observer\ExportOrderAfterInvoiceRegistered;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use MSlwk\GenericOrderExport\Api\OrderExportHandlerInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Framework\Event\Observer;

/**
 * Class ExportOrderAfterInvoiceRegisteredTest
 * @package MSlwk\GenericOrderExport\Test\Unit\Observer
 */
class ExportOrderAfterInvoiceRegisteredTest extends TestCase
{
    /**
     * @var MockObject|OrderExportHandlerInterface
     */
    private $exportHandler;

    /**
     * @var ExportOrderAfterInvoiceRegistered
     */
    private $observer;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->exportHandler = $this->getMockBuilder(OrderExportHandlerInterface::class)
            ->getMock();

        $this->observer = new ExportOrderAfterInvoiceRegistered($this->exportHandler);
    }

    /**
     * @test
     */
    public function testExecute()
    {
        /** @var MockObject|Observer $event */
        $event = $this->getMockBuilder(Observer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $order = $this->getMockBuilder(OrderInterface::class)
            ->getMock();
        $event->expects($this->once())
            ->method('getData')
            ->with('order')
            ->willReturn($order);
        $this->exportHandler->expects($this->once())
            ->method('handleOrderExport')
            ->with($order);

        $this->observer->execute($event);
    }
}
