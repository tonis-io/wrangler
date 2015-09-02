<?php
namespace Tonis\Wrangler;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Task
{
    const TYPE_PARAM = 0;
    const TYPE_QUERY = 1;

    /** @var int */
    private $type;
    /** @var string */
    private $name;
    /** @var callable|string */
    private $middleware;
    /** @var ContainerInterface */
    private $container;
    /** @var mixed */
    public $value;

    /**
     * @param int                $type
     * @param string             $name
     * @param callable|string    $middleware
     * @param ContainerInterface $container
     */
    public function __construct($type, $name, $middleware, ContainerInterface $container = null)
    {
        $this->type       = $type;
        $this->name       = $name;
        $this->middleware = $middleware;
        $this->container  = $container;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable               $next
     * @return ResponseInterface
     * @throws Exception\InvalidMiddleware
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $middleware = $this->middleware;

        if (is_string($middleware) && $this->container && $this->container->has($middleware)) {
            $middleware = $this->container->get($middleware);
        }
        if (!is_callable($middleware)) {
            throw new Exception\InvalidMiddleware();
        }

        return $middleware($this->value, $request, $response, $next);
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return callable|string
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }
}