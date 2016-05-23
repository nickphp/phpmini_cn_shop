<?php
namespace MShop\Service\Common;
use Phalcon\DI;
class BaseService {
    protected $di;
    public function __construct()
    {
        $this->di = DI::getDefault();
    }
}