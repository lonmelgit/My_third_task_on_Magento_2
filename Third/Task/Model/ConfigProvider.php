<?php

namespace Third\Task\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\View\LayoutInterface;

class ConfigProvider implements ConfigProviderInterface
{

    protected $_layout;


    public function __construct(LayoutInterface $layout)

    {

        $this->_layout = $layout;


    }


    public function getConfig()

    {

        return [

            'cms_block' => $this->cmsBlock

        ];

    }

}
