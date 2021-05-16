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

    /**
     * @return string
     */
    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    /**
     * @param string $serviceName
     */
    public function setServiceName(string $serviceName): void
    {
        $this->serviceName = $serviceName;
    }

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     */
    public function setGroupName(string $groupName): void
    {
        $this->groupName = $groupName;
    }

    /**
     * @return string
     */
    public function getNamespaceId(): string
    {
        return $this->namespaceId;
    }

    /**
     * @param string $namespaceId
     */
    public function setNamespaceId(string $namespaceId): void
    {
        $this->namespaceId = $namespaceId;
    }

    /**
     * @return float
     */
    public function getProtectThreshold(): float
    {
        return $this->protectThreshold;
    }

    /**
     * @param float $protectThreshold
     */
    public function setProtectThreshold(float $protectThreshold): void
    {
        $this->protectThreshold = $protectThreshold;
    }

    /**
     * @return string
     */
    public function getMetadata(): string
    {
        return $this->metadata;
    }

    /**
     * @param string $metadata
     */
    public function setMetadata(string $metadata): void
    {
        $this->metadata = $metadata;
    }

    /**
     * @return string
     */
    public function getSelector(): string
    {
        return $this->selector;
    }

    /**
     * @param string $selector
     */
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
