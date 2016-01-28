Category Layered
================
This Magento extension enables you to use category branches as filters in layered navigation.

Facts
-----
- version: 1.0
- extension key: -
- extension on Magento Connect: -
- Magento Connect 1.0 extension key: -
- Magento Connect 2.0 extension key: -
- [extension on GitHub](https://github.com/bitbull-team/magento-module-category-layered)

Description
-----------
This Magento extension enables you to use category branches as filters in layered navigation.
With this solution you can avoid to replicate and maintain data between categories and product attributes.

Usage
-----
In order to use this extension you have to specify the list of categories you want to show as filters in catalog layered navigation
System > Configuration > Bitbull > Category Layered Navigation

You can add a list of category branches, for each one you have to specify:
- category id
- request var for filter application
- position of the block relative to the represented filter

This configuration is available on a store view level.

The extension does not generate any modification of the database structure.

Compatibility
-------------
- Magento >= 1.9.1.0

Installation Instructions
-------------------------
1. Download the extension from extension page on Bitbucket and copy all the files into your document root.
2. Clear the cache, logout from the admin panel and then login again.
3. Configure categories under System > Configuration > Bitbull > Category Layered Navigation

Uninstallation
--------------
No SQL query is need to be run after removing the extension files.

Support
-------
If you have any issue with this extension you can [open an issue on GitHub](https://github.com/bitbull-team/magento-module-category-layered/issues)

Contribution
------------
Any contributions are highly appreciated. Ideas or code improvements can be discussed opening a [pull request on GitHub](https://help.github.com/articles/using-pull-requests)

Developer
---------
Nadia Sala
[http://www.bitbull.it](http://www.bitbull.it)
[@nadiasala](https://twitter.com/nadiasala)

Licence
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
(c) 2016 Bitbull Srl
