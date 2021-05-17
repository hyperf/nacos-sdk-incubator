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

use Hyperf\NacosSdk\Provider\AccessToken;
use Hyperf\NacosSdk\Provider\Auth;
use Hyperf\NacosSdk\Provider\NacosConfig;
use Hyperf\NacosSdk\Provider\NacosInstance;
use Hyperf\NacosSdk\Provider\NacosOperator;
use Hyperf\NacosSdk\Provider\NacosService;

/**
 * @property AccessToken $accessToken
 * @property Auth $auth
 * @property NacosConfig $config
 * @property NacosInstance $instance
 * @property NacosOperator $operator
 * @property NacosService $service
 */
interface NacosClientInterface
{
}
