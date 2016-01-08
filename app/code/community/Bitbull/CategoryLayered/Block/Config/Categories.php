<?php
/**
 * @category Bitbull
 * @package  Bitbull_CategoryLayered
 * @author   Nadia Sala <nadia.sala@bitbull.it>
 */
class Bitbull_CategoryLayered_Block_Config_Categories
    extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    /**
     * Prepare table with configuration fields
     */
    public function _prepareToRender()
    {
        $this->addColumn('category', array(
            'label' => Mage::helper('bitbull_categorylayered')->__('Category Id'),
            'style' => 'width:100px',
        ));
        $this->addColumn('filter', array(
            'label' => Mage::helper('bitbull_categorylayered')->__('Request param'),
            'style' => 'width:250px',
        ));
        $this->addColumn('position', array(
            'label' => Mage::helper('bitbull_categorylayered')->__('Position'),
            'style' => 'width:100px',
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('bitbull_categorylayered')->__('Add');
    }
}
