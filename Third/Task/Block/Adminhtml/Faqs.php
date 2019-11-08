<?php
namespace Third\Task\Block\Adminhtml;

class Faqs extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_faqs';
        $this->_blockGroup = 'Third_Task';
        $this->_headerText = __('Manage Faqs');

        parent::_construct();

        if ($this->_isAllowedAction('Third_Task::save')) {
            $this->buttonList->update('add', 'label', __('Add Questions'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
