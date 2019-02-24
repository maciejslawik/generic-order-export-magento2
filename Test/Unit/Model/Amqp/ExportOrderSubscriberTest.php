<?php
declare(strict_types=1);

/**
 * File:ExportOrderSubscriberTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Test\Unit\Model\Amqp;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\Data\OrderInterface;
use MSlwk\GenericOrderExport\Model\Amqp\ExportOrderMessage;
use MSlwk\GenericOrderExport\Model\Amqp\ExportOrderSubscriber;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Magento\Sales\Api\OrderRepositoryInterface;
use MSlwk\GenericOrderExport\Api\OrderExportServiceInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ExportOrderSubscriberTest
 * @package MSlwk\GenericOrderExport\Test\Unit\Model\Amqp
 */
class ExportOrderSubscriberTest extends TestCase
{
    /**
     * @var MockObject|OrderExportServiceInterface
     */
    private $orderExportService;

    /**
     * @var MockObject|OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var MockObject|LoggerInterface
     */
    private $logger;

    /**
     * @var ExportOrderSubscriber
     */
    private $subscriber;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->orderExportService = $this->getMockBuilder(OrderExportServiceInterface::class)
            ->getMock();
        $this->orderRepository = $this->getMockBuilder(OrderRepositoryInterface::class)
            ->getMock();
        $this->logger = $this->getMockBuilder(LoggerInterface::class)
            ->getMock();

        $this->subscriber = new ExportOrderSubscriber(
            $this->orderExportService,
            $this->orderRepository,
            $this->logger
        );
    }

    /**
     * @test
     */
    public function testProcessMessageWhenProcessedSuccessfully()
    {
        $orderId = '321';
        $message = new ExportOrderMessage();
        $message->setOrderId($orderId);
        $order = $this->getMockBuilder(OrderInterface::class)
            ->getMock();
        $this->orderRepository->expects($this->once())
            ->method('get')
            ->with((int)$orderId)
            ->willReturn($order);
        $this->orderExportService->expects($this->once())
            ->method('exportOrder')
            ->with($order);
        $this->logger->expects($this->never())
            ->method('error');

        $this->subscriber->processMessage($message);
    }

    /**
     * @test
     */
    public function testProcessMessageWhenOrderNotExists()
    {
        $orderId = '321';
        $message = new ExportOrderMessage();
        $message->setOrderId($orderId);
        $this->orderRepository->expects($this->once())
            ->method('get')
            ->with((int)$orderId)
            ->willThrowException(new NoSuchEntityException());
        $this->orderExportService->expects($this->never())
            ->method('exportOrder');
        $this->logger->expects($this->once())
            ->method('error');

        $this->subscriber->processMessage($message);
    }
}
