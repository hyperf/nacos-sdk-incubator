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

use Hyperf\NacosSdk\Exception\InvalidArgumentException;
use Hyperf\NacosSdk\Provider\AccessToken;
use Hyperf\NacosSdk\Provider\Auth;
use Hyperf\NacosSdk\Provider\NacosConfig;
use Hyperf\NacosSdk\Provider\NacosInstance;
use Hyperf\NacosSdk\Provider\NacosOperator;
use Hyperf\NacosSdk\Provider\NacosService;

class Application implements NacosClientInterface
{
    protected $alias = [
        'accessToken' => AccessToken::class,
        'auth' => Auth::class,
        'config' => NacosConfig::class,
        'instance' => NacosInstance::class,
        'operator' => NacosOperator::class,
        'service' => NacosService::class,
    ];

    /**
     * @var array
     */
    protected $providers = [];

    /**
     * @var Config
     */
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function __get($name)
    {
        if (! isset($name) || ! isset($this->alias[$name])) {
            throw new InvalidArgumentException("{$name} is invalid.");
        }

        if (isset($this->providers[$name])) {
            return $this->providers[$name];
        }

        $class = $this->alias[$name];
        return $this->providers[$name] = new $class($this, $this->config);
    }
}
