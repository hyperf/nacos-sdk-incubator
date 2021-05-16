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
namespace Hyperf\NacosSdk\Provider;

use Hyperf\NacosSdk\Application;

trait AccessToken
{
    /**
     * @var null|string
     */
    private $accessToken;

    /**
     * @var int
     */
    private $expireTime = 0;

    public function getAccessToken(): ?string
    {
        $username = $this->config->get('nacos.username');
        $password = $this->config->get('nacos.password');

        if ($username === null || $password === null) {
            return null;
        }

        if (! $this->isExpired()) {
            return $this->accessToken;
        }

        /** @var Application $application */
        $application = $this->container->get(Application::class);

        $result = $application->auth->login($username, $password);

        $this->accessToken = $result['accessToken'];
        $this->expireTime = $result['tokenTtl'] + time();

        return $this->accessToken;
    }

    protected function isExpired(): bool
    {
        if (isset($this->accessToken) && $this->expireTime > time() + 60) {
            return false;
        }
        return true;
    }
}
