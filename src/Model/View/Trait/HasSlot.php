<?php

declare(strict_types=1);

namespace Mvenghaus\PhpViewComponents\Model\View\Trait;

use Mvenghaus\PhpViewComponents\Exception\InvalidSlotModeException;
use Mvenghaus\PhpViewComponents\Exception\NoOpenSlotsException;

trait HasSlot
{
    private const SLOT_SEPARATOR = '<!-- SLOT -->';
    private const SLOT_MODE_OPEN = 'open';
    private const SLOT_MODE_CLOSE = 'close';

    private ?string $slotMode = null;

    private static array $slotStack = [];

    public static function slot(): string
    {
        return self::SLOT_SEPARATOR;
    }

    public function start(): self
    {
        $this->slotMode = self::SLOT_MODE_OPEN;

        return $this;
    }

    public function stop(): self
    {
        $this->slotMode = self::SLOT_MODE_CLOSE;

        return $this;
    }

    /**
     * @throws InvalidSlotModeException
     * @throws NoOpenSlotsException
     */
    public function __toString(): string
    {
        if ($this->slotMode === null) {
            throw new InvalidSlotModeException();
        }

        if ($this->slotMode === self::SLOT_MODE_CLOSE) {
            if (count(self::$slotStack[__CLASS__]) === 0) {
                throw new NoOpenSlotsException();
            }

            return array_pop(self::$slotStack[__CLASS__]);
        }

        $content = parent::__toString();

        [$start, $stop] = explode(self::SLOT_SEPARATOR, $content);

        self::$slotStack[__CLASS__] = [...(self::$slotStack[__CLASS__] ?? []), $stop];

        return $start;
    }
}
