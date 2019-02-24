<?php
declare(strict_types=1);

/**
 * File:ConfigProviderTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Test\Unit\Model;

use MSlwk\GenericOrderExport\Model\ConfigProvider;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class ConfigProviderTest
 * @package MSlwk\GenericOrderExport\Test\Unit\Model
 */
class ConfigProviderTest extends TestCase
{
    /**
     * @var MockObject|ScopeConfigInterface
     */
    private $config;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->config = $this->getMockBuilder(ScopeConfigInterface::class)
            ->getMock();

        $this->configProvider = new ConfigProvider($this->config);
    }

    /**
     * @param $value
     * @param $expected
     * @test
     * @dataProvider isExportAsyncDataProvider
     */
    public function testIsExportAsync($value, $expected)
    {
        $this->config->expects($this->once())
            ->method('getValue')
            ->with('sales/order_export/async_enabled')
            ->willReturn($value);

        $result = $this->configProvider->isExportAsync();

        $this->assertSame($expected, $result);
    }

    /**
     * @return array
     */
    public function isExportAsyncDataProvider(): array
    {
        return [
            [
                '0',
                false
            ],
            [
                null,
                false
            ],
            [
                '1',
                true
            ]
        ];
    }
}
