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
namespace HyperfTest\NacosSdk\Cases\Provider;

use Hyperf\NacosSdk\Application;
use HyperfTest\NacosSdk\AbstractTestCase;

/**
 * @internal
 * @coversNothing
 */
class NacosAuthTest extends AbstractTestCase
{
    public function testLogin()
    {
        $application = new Application($this->getContainer());
        $result = $application->auth->login('nacos', 'nacos');
        $this->assertSame($result['accessToken'], $application->auth->getAccessToken());
        $this->assertSame($result['tokenTtl'], 18000);
        $this->assertSame($result['globalAdmin'], true);
    }
}
