# hyperf-limiter
hyperf框架api接口限流

[![Latest Stable Version](https://poser.pugx.org/zerduo/hyperf-limiter/v)](//packagist.org/packages/zerduo/hyperf-limiter) 
[![Total Downloads](https://poser.pugx.org/zerduo/hyperf-limiter/downloads)](//packagist.org/packages/zerduo/hyperf-limiter)
[![License](https://poser.pugx.org/zerduo/hyperf-limiter/license)](//packagist.org/packages/zerduo/hyperf-limiter)

## Installation

```bash
 composer require zerduo/hyperf-limiter
```
## config
```bash
php bin/hyperf.php vendor:publish zerduo/hyperf-limiter
```

## middlewares.php
- 增加：\Zerduo\HyperfLimiter\LimiterMiddleware::class

