[![Latest Stable Version](https://poser.pugx.org/mslwk/module-generic-generic-order-export/v/stable)](https://packagist.org/packages/mslwk/module-generic-generic-order-export)
[![License](https://poser.pugx.org/mslwk/module-generic-generic-order-export/license)](https://packagist.org/packages/mslwk/module-generic-generic-order-export)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/maciejslawik/generic-order-export-magento2/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/maciejslawik/generic-order-export-magento2/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/maciejslawik/generic-order-export-magento2/badges/build.png?b=master)](https://scrutinizer-ci.com/g/maciejslawik/generic-order-export-magento2/build-status/master)
[![Total Downloads](https://poser.pugx.org/mslwk/module-generic-order-export/downloads)](https://packagist.org/packages/mslwk/module-generic-order-export)

# Magento 2 Generic Order Export module #

The extension provides a simple API for exporting new orders to a 3rd-party service. You can use it as a base for your
specialised module. By default it exports an order after invoice creation.
By default it used RabbitMQ to send the orders asynchronously for smoother experience. This feature can be disabled via
backend panel.

### Installation ###

##### Via Composer #####

To install the extension using Composer use the 
following commands:

```bash
 composer require mslwk/module-generic-order-export
 php bin/magento module:enable MSlwk_GenericOrderExport
 php bin/magento setup:upgrade
 ```
 
##### From GitHub #####
 
You can download the extension directly from GitHub and 
put it inside `` app/code/MSlwk/GenericOrderExport `` directory. Then run the
following commands:

```bash
 php bin/magento module:enable MSlwk_GenericOrderExport
 php bin/magento setup:upgrade
 ```
 
## Usage ##

To use this module you are required to do several things. You are strongly advised to create your own module extending
contents of this one.

1. 
    Create your own implementation of the ``MSlwk\GenericOrderExport\Api\OrderExportServiceInterface`` responsible
    for the actual export process and add a preference to your ``etc/di.xml`` like this:
    
    ```
       <preference for="MSlwk\GenericOrderExport\Api\OrderExportServiceInterface"
                   type="You\YourModel\Model\YourOrderExportService" />
    ```

2.
    If you don't want to use RabbitMQ to queue the export process go to
    ``Stores -> Configuration -> Sales -> Sales -> Order Export -> Enable async export``
    
3. 
    If you want to export your orders under different conditions disable the default observer responsible for exporting
    the orders (``mslwk_order_export_sales_order_invoice_register``) via your ``etc/events.xml``. After that you have to
    create your own plugin/observer/whatever to export the orders. Go to ``MSlwk\GenericOrderExport\Observer\ExportOrderAfterInvoiceRegistered``
    for reference. 
        
4. If you need a fallback mechanism in case of export failure you have to implement it yourself to reflect your needs.
        
## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/maciejslawik/generic-order-export-magento2/tags). 

## Authors

* **Maciej Sławik** - https://github.com/maciejslawik

See also the list of [contributors](https://github.com/maciejslawik/generic-order-export-magento2/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details