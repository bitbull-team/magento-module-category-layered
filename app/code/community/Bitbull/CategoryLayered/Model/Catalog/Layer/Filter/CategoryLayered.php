<?php
/**
 * @category Bitbull
 * @package  Bitbull_CategoryLayered
 * @author   Nadia Sala <nadia.sala@bitbull.it>
 */
class Bitbull_CategoryLayered_Model_Catalog_Layer_Filter_CategoryLayered extends Mage_Catalog_Model_Layer_Filter_Abstract
{
    /**
     * root category representing attribute for layered navigation
     * @var Mage_Catalog_Model_Category
     */
    protected $_rootCategory;

    /**
     * current filter category
     * @var Mage_Catalog_Model_Category
     */
    protected $_appliedCategory;

    /**
     * Set root category
     * @param Mage_Catalog_Model_Category $category
     */
    public function setRootCategory(Mage_Catalog_Model_Category $category) {
        $this->_rootCategory = $category;
    }

    /**
     * Apply category filter to layer
     *
     * @param   Zend_Controller_Request_Abstract $request
     * @param   Mage_Core_Block_Abstract $filterBlock
     * @return  Mage_Catalog_Model_Layer_Filter_Category
     */
    public function apply(Zend_Controller_Request_Abstract $request, $filterBlock)
    {
        $filter = (int) $request->getParam($this->getRequestVar());
        if (!$filter) {
            return $this;
        }

        // load data for applied category
        $this->_appliedCategory = Mage::getModel('catalog/category')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($filter);

        if ($this->_appliedCategory->getId()) {

            // create join and conditions for additional category filter
            $tableAlias = 'category_layered_'.$this->_rootCategory->getId();
            $conditions = array();
            $conditions['category_id']  = $filter;
            $conditions['store_id']     = Mage::app()->getStore()->getId();
            if (!$this->_appliedCategory->getIsAnchor()) {
                $conditions['is_parent'] = 1;
            }
            $this->getLayer()->getProductCollection()
                ->joinTable(array($tableAlias => 'catalog/category_product_index'), "product_id=entity_id", array($tableAlias.'_cat_id' => 'category_id', $tableAlias.'_store_id' => 'store_id'), $conditions, 'inner');

            // add filter to layer state
            $this->getLayer()->getState()->addFilter(
                $this->_createItem($this->_appliedCategory->getName(), $filter)
            );

            // if current applied category has no children reset items array (for hiding filter block)
            if (!$this->_appliedCategory->getChildrenCategories()->count()) {
                $this->_items = array();
            }

        }

        return $this;
    }

    /**
     * Get filter name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_rootCategory->getName();
    }

    /**
     * Get data array for building filter items
     *
     * @return array
     */
    protected function _getItemsData()
    {
        $key = $this->getLayer()->getStateKey().'_'.$this->_requestVar;
        $data = $this->getLayer()->getAggregator()->getCacheData($key);

        if ($data === null) {

            // load children for root category or current selected category for this filter
            $categories = $this->_appliedCategory instanceof Mage_Catalog_Model_Category ?
                            $this->_appliedCategory->getChildrenCategories() :
                            $this->_rootCategory->getChildrenCategories();

            $this->getLayer()->getProductCollection()
                ->addCountToCategories($categories);

            $data = array();
            foreach ($categories as $category) {
                /** @var $category Mage_Catalog_Model_Categeory */
                if ($category->getIsActive() && $category->getProductCount()) {
                    $data[] = array(
                        'label' => Mage::helper('core')->escapeHtml($category->getName()),
                        'value' => $category->getId(),
                        'count' => $category->getProductCount(),
                    );
                }
            }
            $tags = $this->getLayer()->getStateTags();
            $this->getLayer()->getAggregator()->saveCacheData($data, $key, $tags);
        }
        return $data;
    }

}