<?php
namespace Mageplaza\HelloWorld\Model;

class PostManagement {

    public function getPost($param)
    {
        return 'api GET return the $param ' . $param;
    }
}