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
namespace HyperfTest\NacosSdk\Cases;

use Hyperf\NacosSdk\Application;
use Hyperf\NacosSdk\Provider\NacosAuth;
use Hyperf\NacosSdk\Provider\NacosConfig;
use Hyperf\NacosSdk\Provider\NacosInstance;
use Hyperf\NacosSdk\Provider\NacosOperator;
use Hyperf\NacosSdk\Provider\NacosService;
use HyperfTest\NacosSdk\AbstractTestCase;

/**
 * @internal
 * @coversNothing
 */
class ApplicationTest extends AbstractTestCase
{
    public function testApplication()
    {
        $application = new Application($this->getContainer());

        $this->assertInstanceOf(NacosAuth::class, $application->auth);
        $this->assertInstanceOf(NacosConfig::class, $application->config);
        $this->assertInstanceOf(NacosInstance::class, $application->instance);
        $this->assertInstanceOf(NacosOperator::class, $application->operator);
        $this->assertInstanceOf(NacosService::class, $application->service);
    }
}
