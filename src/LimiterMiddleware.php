<?php

declare(strict_types=1);

namespace Zerduo\HyperfLimiter;

use Hyperf\HttpServer\Router\Dispatched;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LimiterMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected $limiter;


    public function __construct(ContainerInterface $container, LimiterInterface $limiter)
    {
        $this->container = $container;
        $this->limiter = $limiter;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uniqueId = $this->getClienUniqueId($request);
        $canRequest = $this->limiter->canRequest($uniqueId);
        if (!$canRequest) {
            throw new \Exception('请求过于频繁', 500);
        }
        return $handler->handle($request);
    }

    /**
     * @param ServerRequestInterface $request
     * @return mixed|string
     */
    protected function getClienUniqueId(ServerRequestInterface $request)
    {
        $dispatcher = $request->getAttribute(Dispatched::class);
        $route = $dispatcher->handler->route;
        $res = $request->getServerParams();
        if (isset($res['http_client_ip'])) {
            return $res['http_client_ip'];
        }
        if (isset($res['http_x_real_ip'])) {
            return $res['http_x_real_ip'];
        }
        if (isset($res['http_x_forwarded_for'])) {
            //部分CDN会获取多层代理IP，所以转成数组取第一个值
            $arr = explode(',', $res['http_x_forwarded_for']);
            return $arr[0];
        }
        $uniqueId = $res['remote_addr'];
        if ($route) {
            $uniqueId .= ':' . $route;
        }
        return $uniqueId;
    }
}