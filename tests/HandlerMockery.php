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
namespace HyperfTest\NacosSdk;

use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7;
use Psr\Http\Message\RequestInterface;

class HandlerMockery
{
    public function __invoke(RequestInterface $request, array $options)
    {
        $uri = $request->getUri()->getPath();
        switch ($uri) {
            case '/nacos/v1/auth/users/login':
                $response = new Psr7\Response(
                    200,
                    [],
                    file_get_contents(__DIR__ . '/json/login.json')
                );
                break;
            case '/nacos/v1/cs/configs':
                $response = new Psr7\Response(
                    200,
                    [],
                    file_get_contents(__DIR__ . '/json/get_config.json')
                );
                break;
            case '/nacos/v1/ns/instance/list':
                $response = new Psr7\Response(
                    200,
                    [],
                    file_get_contents(__DIR__ . '/json/instance_list.json')
                );
                break;
            case '/nacos/v1/ns/instance':
                $response = new Psr7\Response(
                    200,
                    [],
                    file_get_contents(__DIR__ . '/json/instance_detail.json')
                );
                break;
        }

        return new FulfilledPromise($response);
    }
}
