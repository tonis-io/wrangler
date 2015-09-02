<?php
namespace Tonis\Wrangler\Exception;

class InvalidMiddleware extends \LogicException
{
    public function __construct()
    {
        parent::__construct('Cannot wrangle invalid middleware');
    }
}