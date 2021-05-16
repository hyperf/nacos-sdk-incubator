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
use Hyperf\NacosSdk\Model\ConfigModel;
use HyperfTest\NacosSdk\AbstractTestCase;

/**
 * @internal
 * @coversNothing
 */
class NacosConfigTest extends AbstractTestCase
{
    public function testGet()
    {
        $application = new Application($this->getContainer());
        $configModel = new ConfigModel();
        $configModel->setDataId('hyperf-service-config');
        $configModel->setGroup('DEFAULT_GROUP');
        $result = $application->config->get($configModel);
        $this->assertSame(['A' => 'A'], $result);
    }
}
