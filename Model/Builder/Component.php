<?php

declare(strict_types=1);

namespace Mvenghaus\PhpViewComponents\Model\Builder;

use Magento\Framework\App\ObjectManager;

/**
 * @template T
 */
final readonly class Component
{
    /**
     * @param class-string<T> $className
     * @return T
     */
    public static function of(string $className)
    {
        return ObjectManager::getInstance()->create($className);
    }
}
