<?php

declare(strict_types=1);

namespace Zerduo\HyperfLimiter;

interface LimiterInterface
{
    public function canRequest($ip): bool;
}