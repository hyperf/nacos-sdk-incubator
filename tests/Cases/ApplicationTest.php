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
use Hyperf\NacosSdk\Config;
use Hyperf\NacosSdk\Provider\Auth;
use Hyperf\NacosSdk\Provider\Configs;
use Hyperf\NacosSdk\Provider\Instance;
use Hyperf\NacosSdk\Provider\Operator;
use Hyperf\NacosSdk\Provider\Service;
use HyperfTest\NacosSdk\AbstractTestCase;

/**
 * @internal
 * @coversNothing
 */
class ApplicationTest extends AbstractTestCase
{
    public function testApplication()
    {
        $application = new Application(new Config());

        $this->assertInstanceOf(Auth::class, $application->auth);
        $this->assertInstanceOf(Configs::class, $application->configs);
        $this->assertInstanceOf(Instance::class, $application->instance);
        $this->assertInstanceOf(Operator::class, $application->operator);
        $this->assertInstanceOf(Service::class, $application->service);
    }
}
