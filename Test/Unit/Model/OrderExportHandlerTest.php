<?php
declare(strict_types=1);

/**
 * File:OrderExportHandlerTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Test\Unit\Model;

use MSlwk\GenericOrderExport\Model\OrderExportHandler;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Exception;
use Magento\Framework\MessageQueue\PublisherInterface;
use Magento\Sales\Api\Data\OrderInterface;
use MSlwk\GenericOrderExport\Api\Amqp\ExportOrderMessageInterface;
use MSlwk\GenericOrderExport\Api\Amqp\ExportOrderMessageInterfaceFactory;
use MSlwk\GenericOrderExport\Api\ConfigProviderInterface;
use MSlwk\GenericOrderExport\Api\OrderExportHandlerInterface;
use MSlwk\GenericOrderExport\Api\OrderExportServiceInterface;
use Psr\Log\LoggerInterface;

/**
 * Class OrderExportHandlerTest
 * @package MSlwk\GenericOrderExport\Test\Unit\Model
 */
class OrderExportHandlerTest extends TestCase
{
    /**
     * @var MockObject|ConfigProviderInterface
     */
    private $configProvider;

    /**
     * @var MockObject|ExportOrderMessageInterfaceFactory
     */
    private $exportOrderMessageFactory;

    /**
     * @var MockObject|PublisherInterface
     */
    private $publisher;

    /**
     * @var MockObject|OrderExportServiceInterface
     */
    private $orderExportService;

    /**
     * @var MockObject|LoggerInterface
     */
    private $logger;

    /**
     * @var OrderExportHandler
     */
    private $orderExportHandler;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->configProvider = $this->getMockBuilder(ConfigProviderInterface::class)
            ->getMock();
        $this->exportOrderMessageFactory = $this->getMockBuilder(ExportOrderMessageInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->publisher = $this->getMockBuilder(PublisherInterface::class)
            ->getMock();
        $this->orderExportService = $this->getMockBuilder(OrderExportServiceInterface::class)
            ->getMock();
        $this->logger = $this->getMockBuilder(LoggerInterface::class)
            ->getMock();

        $this->orderExportHandler = new OrderExportHandler(
            $this->configProvider,
            $this->exportOrderMessageFactory,
            $this->publisher,
            $this->orderExportService,
            $this->logger
        );
    }

    /**
     * @test
     */
    public function testWhenExportIsNotAsync()
    {
        /** @var MockObject|OrderInterface $order */
        $order = $this->getMockBuilder(OrderInterface::class)
            ->getMock();
        $this->configProvider->expects($this->once())
            ->method('isExportAsync')
            ->willReturn(false);
        $this->orderExportService->expects($this->once())
            ->method('exportOrder')
            ->with($order);
        $this->logger->expects($this->never())
            ->method('error');

        $this->orderExportHandler->handleOrderExport($order);
    }

    /**
     * @test
     */
    public function testWhenExportIsNotAsyncAndErrorOccurs()
    {
        /** @var MockObject|OrderInterface $order */
        $order = $this->getMockBuilder(OrderInterface::class)
            ->getMock();
        $this->configProvider->expects($this->once())
            ->method('isExportAsync')
            ->willReturn(false);
        $this->orderExportService->expects($this->once())
            ->method('exportOrder')
            ->with($order)
            ->willThrowException(new Exception());
        $this->logger->expects($this->once())
            ->method('error');

        $this->orderExportHandler->handleOrderExport($order);
    }

    /**
     * @test
     */
    public function testWhenExportIsAsync()
    {
        /** @var MockObject|OrderInterface $order */
        $order = $this->getMockBuilder(OrderInterface::class)
            ->getMock();
        $order->expects($this->once())
            ->method('getEntityId')
            ->willReturn(123);
        $this->configProvider->expects($this->once())
            ->method('isExportAsync')
            ->willReturn(true);
        $this->orderExportService->expects($this->never())
            ->method('exportOrder');
        /** @var MockObject|ExportOrderMessageInterface $message */
        $message = $this->getMockBuilder(ExportOrderMessageInterface::class)
            ->getMock();
        $this->exportOrderMessageFactory->expects($this->once())
            ->method('create')
            ->willReturn($message);
        $message->expects($this->once())
            ->method('setOrderId')
            ->with('123');
        $this->publisher->expects($this->once())
            ->method('publish')
            ->with('exportNewOrdersTopic', $message);
        $this->logger->expects($this->never())
            ->method('error');

        $this->orderExportHandler->handleOrderExport($order);
    }

    /**
     * @test
     */
    public function testWhenExportIsAsyncAndErrorOccurs()
    {
        /** @var MockObject|OrderInterface $order */
        $order = $this->getMockBuilder(OrderInterface::class)
            ->getMock();
        $order->expects($this->any())
            ->method('getEntityId')
            ->willReturn(123);
        $this->configProvider->expects($this->once())
            ->method('isExportAsync')
            ->willReturn(true);
        $this->orderExportService->expects($this->never())
            ->method('exportOrder');
        /** @var MockObject|ExportOrderMessageInterface $message */
        $message = $this->getMockBuilder(ExportOrderMessageInterface::class)
            ->getMock();
        $this->exportOrderMessageFactory->expects($this->once())
            ->method('create')
            ->willReturn($message);
        $message->expects($this->once())
            ->method('setOrderId')
            ->with('123');
        $this->publisher->expects($this->once())
            ->method('publish')
            ->with('exportNewOrdersTopic', $message)
            ->willThrowException(new Exception());
        $this->logger->expects($this->once())
            ->method('error');

        $this->orderExportHandler->handleOrderExport($order);
    }
}
