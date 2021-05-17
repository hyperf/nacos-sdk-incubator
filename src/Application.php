<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Hyperf\NacosSdk;

use Hyperf\Contract\ContainerInterface;
use Hyperf\NacosSdk\Exception\InvalidArgumentException;
use Hyperf\NacosSdk\Provider\AccessToken;
use Hyperf\NacosSdk\Provider\NacosAuth;
use Hyperf\NacosSdk\Provider\NacosConfig;
use Hyperf\NacosSdk\Provider\NacosInstance;
use Hyperf\NacosSdk\Provider\NacosOperator;
use Hyperf\NacosSdk\Provider\NacosService;

class Application implements NacosClientInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected $alias = [
        'accessToken' => AccessToken::class,
        'auth' => NacosAuth::class,
        'config' => NacosConfig::class,
        'instance' => NacosInstance::class,
        'operator' => NacosOperator::class,
        'service' => NacosService::class,
    ];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __get($name)
    {
        if (! isset($name) || ! isset($this->alias[$name])) {
            throw new InvalidArgumentException("{$name} is invalid.");
        }

        return $this->container->get(
            $this->alias[$name]
        );
    }
}
