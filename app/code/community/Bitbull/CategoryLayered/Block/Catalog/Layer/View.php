<?php
/**
 * @category Bitbull
 * @package  Bitbull_CategoryLayered
 * @author   Nadia Sala <nadia.sala@bitbull.it>
 */
class Bitbull_CategoryLayered_Block_Catalog_Layer_View extends Mage_Catalog_Block_Layer_View
{
    /**
     * State block name
     *
     * @var string
     */
    protected $_categoryLayeredBlockName;

    /**
     * Categories List
     *
     * @var array
     */
    protected $_layeredCategories;


    public function __construct(array $args = array()){

        parent::__construct();
        $this->_layeredCategories = Mage::helper('bitbull_categorylayered')->getConfigConfigurationCategories();
    }

    protected function _initBlocks()
    {
        parent::_initBlocks();
        $this->_categoryLayeredBlockName = 'bitbull_categorylayered/catalog_layer_filter_categoryLayered';
    }

    /**
     * Prepare child blocks
     *
     * @return Mage_Catalog_Block_Layer_View
     */
    protected function _prepareLayout()
    {
        foreach ($this->_layeredCategories as $layeredCatConfig) {

            $categoryId = $layeredCatConfig['category'];

            // check if current category navigation is in path of categorylayered
            $current_category = Mage::helper('catalog')->getCategory();
            if ($current_category->getId() && in_array($categoryId, $current_category->getPathIds())) {
                continue;
            }

            // create categoryLayered filter block
            $blockAttributes = array(
                'categoryId'    => $layeredCatConfig['category'],
                'requestParam'  => $layeredCatConfig['filter']
            );

            $categoryBlock = $this->getLayout()
                ->createBlock($this->_categoryLayeredBlockName, 'categorylayered_'.$categoryId, $blockAttributes)
                ->setLayer($this->getLayer())
                ->init();

            $this->setChild('layeredcategory_'.$categoryId.'_filter', $categoryBlock);
        }

        return parent::_prepareLayout();
    }

    /**
     * Get all layer filters
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = parent::getFilters();

        foreach ($this->_layeredCategories as $layeredCatConfig) {
            $categoryId = $layeredCatConfig['category'];
            $position   = $layeredCatConfig['position'];

            if (($categoryFilter = $this->_getLayeredCategoryFilter($categoryId))) {

                $filters = array_merge(
                    array_slice(
                        $filters,
                        0,
                        $position - 1
                    ),
                    array($categoryFilter),
                    array_slice(
                        $filters,
                        $position - 1,
                        count($filters) - 1
                    )
                );
            }
        }

        return $filters;
    }

    /**
     * Get category attribute filter block
     *
     * @return Bitbull_CategoryLayered_Block_Catalog_Layer_Filter_Category
     */
    protected function _getLayeredCategoryFilter($categoryId)
    {
        return $this->getChild('layeredcategory_'.$categoryId.'_filter');
    }

}
