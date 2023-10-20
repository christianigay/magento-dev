<?php
namespace Mageplaza\HelloWorld\Block;

class Action extends \Magento\Framework\View\Element\Template
{
    protected $_postFactory;
    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Mageplaza\HelloWorld\Model\PostFactory $postFactory
    )
    {
        $this->_postFactory = $postFactory;
        parent::__construct($context);
    }

    public function sayTestAction()
    {
        return __('test action');
    }

    public function getPostCollection()
    {
        $post = $this->_postFactory->create();
        return $post->getCollection();
    }
}