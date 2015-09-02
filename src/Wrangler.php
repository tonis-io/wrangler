<?php
namespace Tonis\Wrangler;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Wrangler
{
    /** @var ContainerInterface|null */
    private $container;
    /** @var Strategy\StrategyInterface */
    private $strategy;

    /** @var Task[] */
    private $tasks = [];

    /**
     * @param Strategy\StrategyInterface $strategy
     * @param ContainerInterface         $container
     */
    public function __construct(Strategy\StrategyInterface $strategy = null, ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->strategy  = $strategy;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable               $next
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $query  = $request->getQueryParams();
        $params = $this->strategy->collectParams($request);
        $runner = new TaskRunner($next);
        $tasks  = [];

        // Aggregate the list of tasks in the order they were received.
        foreach ($this->tasks as $task) {
            $values = $task->getType() == Task::TYPE_QUERY ? $query : $params;

            if (isset($values[$task->getName()])) {
                $task->value = $values[$task->getName()];
                $tasks[]     = $task;
            }
        }

        return $runner($tasks, $request, $response);
    }

    /**
     * @param string          $name
     * @param string|callable $middleware
     */
    public function param($name, $middleware)
    {
        $this->queue(Task::TYPE_PARAM, $name, $middleware);
    }

    /**
     * @param string          $name
     * @param string|callable $middleware
     */
    public function query($name, $middleware)
    {
        $this->queue(Task::TYPE_QUERY, $name, $middleware);
    }

    private function queue($type, $name, $middleware)
    {
        $this->tasks[] = new Task($type, $name, $middleware, $this->container);
    }
}