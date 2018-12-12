<?php

declare(strict_types = 1);

namespace Model\Repository;

use Model\Exceptions\IdentityObjectExistsException;
use Model\Exceptions\EmptyCacheException;
use Model\Entity\IDomainObject;
use Model\Exceptions\InvalidObjectException;

class IdentityMapper
{
    protected $identityMap = [];
    protected $className;

    public function __construct($className)
    {
        $this->className = $className;
    }

    public function add(IDomainObject $object): void
    {
        if ($object instanceof $this->className) {
            $key = $this->getGlobalKey($object->getId());
        } else {
            throw new InvalidObjectException(
                'Object must be instance of '
                . $this->className
            );
        }

        if (!$this->exists($key)) {
            $this->identityMap[$key] = $object;

            return;
        }

        throw new IdentityObjectExistsException(
            'Object with class: '
            . $this->className
            . ', and ID: '
            . $object->getId()
            . ' exists.'
        );
    }

    public function get(int $id): IDomainObject
    {
        $key = $this->getGlobalKey($id);

        if ($this->exists($key)) {
            return $this->identityMap[$key];
        }

        throw new EmptyCacheException('Cache for ' . $key . ' not exists.');
    }

    public function find(int $id): ?IDomainObject
    {
        $key = $this->getGlobalKey($id);

        if ($this->exists($key)) {
            return $this->identityMap[$key];
        }

        return null;
    }

    protected function getGlobalKey(int $id): string
    {
        return sprintf('%s.%d', $this->className, $id);
    }

    protected function exists(string $key): bool
    {
        return isset($this->identityMap[$key]);
    }
}
