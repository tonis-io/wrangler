<?php
namespace Tonis\Wrangler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TaskRunner
{
    /** @var callable */
    private $done;

    /**
     * @param callable $done
     */
    public function __construct(callable $done)
    {
        $this->done = $done;
    }

    /**
     * @param Task[]                 $tasks
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @return mixed
     */
    public function __invoke(
        $tasks,
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $next = function ($request, $response) use (&$tasks, &$next) {
            if (empty($tasks)) {
                $done = $this->done;
                return $done($request, $response);
            }

            /** @var Task $task */
            $task = array_shift($tasks);
            return $task($request, $response, $next);
        };

        return $next($request, $response);
    }
}