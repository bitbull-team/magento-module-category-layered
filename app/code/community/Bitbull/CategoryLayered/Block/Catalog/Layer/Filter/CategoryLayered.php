<?php
/**
 * @category Bitbull
 * @package  Bitbull_CategoryLayered
 * @author   Nadia Sala <nadia.sala@bitbull.it>
 */
class Bitbull_CategoryLayered_Block_Catalog_Layer_Filter_CategoryLayered extends Mage_Catalog_Block_Layer_Filter_Abstract
{
    /**
     * Initialize filter template
     * Define filter model name for custom filter
     */
    public function __construct()
    {
        parent::__construct();
        $this->_filterModelName = 'bitbull_categorylayered/catalog_layer_filter_categoryLayered';
    }

    /**
     * Prepare filter process
     * Add data to categoryLayered model instance
     *
     * @return Mage_Catalog_Block_Layer_Filter_Abstract
     */
    public function _prepareFilter() {

        $category = Mage::getModel('catalog/category')->load($this->getData('categoryId'));
        if ($category->getId()) {
            $this->_filter->setRootCategory($category);
        }

        $this->_filter->setRequestVar($this->getData('requestParam'));

        return parent::_prepareFilter();
    }
}