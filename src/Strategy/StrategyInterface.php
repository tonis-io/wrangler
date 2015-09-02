<?php
namespace Tonis\Wrangler\Strategy;

use Psr\Http\Message\ServerRequestInterface;

interface StrategyInterface
{
    /**
     * This method should return the matched route parameters for specified request. The
     * return value MUST be an array of key => value pairs.
     *
     * @param ServerRequestInterface $request
     * @return array
     */
    public function collectParams(ServerRequestInterface $request);
}