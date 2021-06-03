<?php


namespace Zerduo\HyperfLimiter;


use Hyperf\Contract\ContainerInterface;
use Hyperf\Redis\Redis;

abstract class AbstractLimiter implements LimiterInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Redis|mixed
     */
    protected $redis;

    protected $config;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->redis = $container->get(Redis::class);
        $this->config = config('limiter');
    }

}