<?php
namespace Mageplaza\HelloWorld\Controller\Test;

class Forward extends \Magento\Framework\App\Action\Action
{


    public function execute()
	{
        $this->_forward('hello');
        // $this->_redirect('*/*/hello');
        // echo "Hello World forward";
        // exit;
	}

}