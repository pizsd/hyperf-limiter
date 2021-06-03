<?php
declare(strict_types=1);

namespace Zerduo\HyperfLimiter;

class LeakyBucket extends AbstractLimiter
{
    protected $totalCapacity;

    protected $addNum = 1;

    protected $leakRate;

    protected $lastUpdatedAt;

    protected $redis;

    /**
     * @param $uniqueId
     * @return bool
     */
    public function canRequest($uniqueId): bool
    {
        $limiterKey = 'limiter:' . $uniqueId;
        $whiteList = explode('|', $this->config['white_list']);
        foreach ($whiteList as $item) {
            if (stripos($uniqueId, $item)) {
                return true;
            }
        }
        $limiterUpdateAtKey = $limiterKey . ':last-updated';
        $this->totalCapacity = $this->config['frequency'];
        $this->leakRate = $this->totalCapacity / 60;
        $currentCapacity = 0;
        $currentTime = time();
        $redis = $this->redis;
        if ($redis->exists($limiterKey)) {
            $this->lastUpdatedAt = $redis->get($limiterUpdateAtKey);
            $currentCapacity = $redis->get($limiterKey);
        } else {
            $this->lastUpdatedAt = $currentTime;
        }
        $leakNum = ($currentTime - $this->lastUpdatedAt) * $this->leakRate;
        $laveCapacity = $currentCapacity - floor($leakNum);
        $currentCapacity = ($laveCapacity >= 0) ? $laveCapacity : 0;
        if (($currentCapacity + $this->addNum) <= $this->totalCapacity) {
            $currentCapacity += $this->addNum;
            $redis->set($limiterKey, $currentCapacity);
            $redis->set($limiterUpdateAtKey, $currentTime);
            return true;
        }
        return false;
    }
}