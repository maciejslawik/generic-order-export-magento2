[![Latest Stable Version](https://poser.pugx.org/mslwk/module-generic-generic-order-export/v/stable)](https://packagist.org/packages/mslwk/module-generic-generic-order-export)
[![License](https://poser.pugx.org/mslwk/module-generic-generic-order-export/license)](https://packagist.org/packages/mslwk/module-generic-generic-order-export)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/maciejslawik/generic-order-export-magento2/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/maciejslawik/generic-order-export-magento2/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/maciejslawik/generic-order-export-magento2/badges/build.png?b=master)](https://scrutinizer-ci.com/g/maciejslawik/generic-order-export-magento2/build-status/master)
[![Total Downloads](https://poser.pugx.org/mslwk/module-generic-order-export/downloads)](https://packagist.org/packages/mslwk/module-generic-order-export)

# Magento 2 Generic Order Export module #

The extension allows to handle exporting new orders automatically on creation. It can export
orders either synchronously or asynchronously. 

You only have to implement a method responsible for the actual export to the 3rd party service
you require integration with.

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

TO UPDATE

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/maciejslawik/generic-order-export-magento2/tags). 

## Authors

* **Maciej Sławik** - https://github.com/maciejslawik

See also the list of [contributors](https://github.com/maciejslawik/generic-order-export-magento2/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details