<?php
namespace Mageplaza\HelloWorld\Controller\Action;

class Login extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    )
    {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        // return $this->_forward('hello');

        // echo "Hello World";
        $textDisplay = new \Magento\Framework\DataObject(['text' => 'Mageplaza']);
        $this->_eventManager->dispatch('mageplaza_helloworld_display_text', ['mp_text' => $textDisplay]);
        echo $textDisplay->getText();
        exit;
    }
}