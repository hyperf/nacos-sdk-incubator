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
namespace Hyperf\NacosSdk\Model;

class ServiceModel extends AbstractModel
{
    /**
     * @var string
     */
    protected $serviceName;

    /**
     * @var string
     */
    protected $groupName;

    /**
     * @var string
     */
    protected $namespaceId;

    /**
     * Between 0 to 1.
     * @var float
     */
    protected $protectThreshold = 0.0;

    /**
     * @var string
     */
    protected $metadata;

    /**
     * A JSON string.
     *
     * @var string
     */
    protected $selector;

    /**
     * @var string[]
     */
    protected $requiredFields = ['serviceName'];

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function setServiceName(string $serviceName): void
    {
        $this->serviceName = $serviceName;
    }

    public function getGroupName(): string
    {
        return $this->groupName;
    }

    public function setGroupName(string $groupName): void
    {
        $this->groupName = $groupName;
    }

    public function getNamespaceId(): string
    {
        return $this->namespaceId;
    }

    public function setNamespaceId(string $namespaceId): void
    {
        $this->namespaceId = $namespaceId;
    }

    public function getProtectThreshold(): float
    {
        return $this->protectThreshold;
    }

    public function setProtectThreshold(float $protectThreshold): void
    {
        $this->protectThreshold = $protectThreshold;
    }

    public function getMetadata(): string
    {
        return $this->metadata;
    }

    public function setMetadata(string $metadata): void
    {
        $this->metadata = $metadata;
    }

    public function getSelector(): string
    {
        return $this->selector;
    }

    public function setSelector(string $selector): void
    {
        $this->selector = $selector;
    }

    /**
     * @return string[]
     */
    public function getRequiredFields(): array
    {
        return $this->requiredFields;
    }

    /**
     * @param string[] $requiredFields
     */
    public function setRequiredFields(array $requiredFields): void
    {
        $this->requiredFields = $requiredFields;
    }
}
