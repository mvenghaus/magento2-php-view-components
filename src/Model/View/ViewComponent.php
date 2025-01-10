<?php

declare(strict_types=1);

namespace Mvenghaus\PhpViewComponents\Model\View;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\View\Element\Template\File\Resolver as TemplateFileResolver;

abstract class ViewComponent
{
    protected string $template;

    protected function isValid(): bool
    {
        return true;
    }

    public function __toString(): string
    {
        if (!$this->isValid()) {
            return '';
        }

        ob_start();

        $view = $this;

        require ObjectManager::getInstance()->get(TemplateFileResolver::class)
            ->getTemplateFileName($this->template);

        return ob_get_clean();
    }

    /**
     * @template T
     * @param class-string<T> $className
     * @return T
     */
    public static function instance(string $className)
    {
        return ObjectManager::getInstance()->get($className);
    }

    /**
     * @template T
     * @param class-string<T> $className
     * @return T
     */
    public static function viewModel(string $className)
    {
        return ObjectManager::getInstance()->get($className);
    }
}
