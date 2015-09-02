<?php
namespace Tonis\Wrangler\Strategy;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\RouterInterface;

final class Expressive implements StrategyInterface
{
    /** @var RouterInterface */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritDoc}
     */
    public function collectParams(ServerRequestInterface $request)
    {
        return $this->router->match($request)->getMatchedParams();
    }
}