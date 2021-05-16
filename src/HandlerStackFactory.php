<?php


namespace Hyperf\NacosSdk;


use GuzzleHttp\HandlerStack;
use Hyperf\Contract\ContainerInterface;
use Hyperf\Guzzle\HandlerStackFactory as HyperfHandlerStackFactory;

class HandlerStackFactory
{
    /**
     * @var callable[]|HandlerStack[]
     */
    protected $stacks = [];

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function set(string $name, $handler)
    {
        $this->stacks[$name] = $handler;
    }

    /**
     * @return callable|HandlerStack
     */
    public function get(string $name)
    {
        if (! isset($this->stacks[$name])) {
            $this->stacks[$name] = $this->getDefaultHandlerStack();
        }

        return $this->stacks[$name];
    }

    public function getDefaultHandlerStack(): HandlerStack
    {
        return $this->container->get(HyperfHandlerStackFactory::class)->create();
    }
}