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

use GuzzleHttp\RequestOptions;
use Hyperf\NacosSdk\AbstractProvider;
use Hyperf\NacosSdk\Exception\RuntimeException;
use Hyperf\NacosSdk\Model\ConfigModel;

class ConfigProvider extends AbstractProvider
{
    public function get(ConfigModel $configModel)
    {
        $response = $this->request('GET', '/nacos/v1/cs/configs', [
            RequestOptions::QUERY => $configModel->toArray(),
        ]);

        try {
            return $this->handleResponse($response);
        } catch (RuntimeException $exception) {
            return [];
        }
    }

    public function set(ConfigModel $configModel): array
    {
        $response = $this->request('POST', '/nacos/v1/cs/configs', [
            RequestOptions::FORM_PARAMS => $configModel->toArray(),
        ]);

        return $this->handleResponse($response);
    }

    public function delete(ConfigModel $configModel): array
    {
        $response = $this->request('DELETE', '/nacos/v1/cs/configs', [
            RequestOptions::QUERY => $configModel->toArray(),
        ]);

        return $this->handleResponse($response);
    }
}
