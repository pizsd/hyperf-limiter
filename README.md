# hyperf-limiter
hyperf框架api接口限流

[![Latest Stable Version](https://poser.pugx.org/zerduo/rabbitmq-delay/v)](//packagist.org/packages/zerduo/rabbitmq-delay)
[![Total Downloads](https://poser.pugx.org/zerduo/rabbitmq-delay/downloads)](//packagist.org/packages/zerduo/rabbitmq-delay)
[![License](https://poser.pugx.org/zerduo/rabbitmq-delay/license)](//packagist.org/packages/zerduo/rabbitmq-delay)

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

