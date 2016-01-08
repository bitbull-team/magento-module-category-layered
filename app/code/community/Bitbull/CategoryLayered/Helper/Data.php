<?php
/**
 * @category Bitbull
 * @package  Bitbull_CategoryLayered
 * @author   Nadia Sala <nadia.sala@bitbull.it>
 */
class Bitbull_CategoryLayered_Helper_Data extends Mage_Core_Helper_Abstract {

    const XML_PATH_CONFIG_CONFIGURATION_CATEGORIES = 'bitbull_categorylayered/configuration/categories';

    public static function getConfig_Configuration_Categories() {
        $categories = Mage::getStoreConfig(self::XML_PATH_CONFIG_CONFIGURATION_CATEGORIES);
        return unserialize($categories);
    }

}