<?php
declare(strict_types=1);

/**
 * File:ConfigProvider.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\GenericOrderExport\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use MSlwk\GenericOrderExport\Api\ConfigProviderInterface;

/**
 * Class ConfigProvider
 * @package MSlwk\GenericOrderExport\Model
 */
class ConfigProvider implements ConfigProviderInterface
{
    /**
     * @var string
     */
    private const XML_PATH_ORDER_EXPORT_ASYNC = 'sales/order_export/async_enabled';

    /**
     * @var ScopeConfigInterface
     */
    private $config;

    /**
     * ConfigProvider constructor.
     * @param ScopeConfigInterface $config
     */
    public function __construct(ScopeConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @return bool
     */
    public function isExportAsync(): bool
    {
        return (bool)$this->config->getValue(self::XML_PATH_ORDER_EXPORT_ASYNC);
    }
}