<?php

/**
 * Part of earth project.
 *
 * @copyright  Copyright (C) 2022 __ORGANIZATION__.
 * @license    __LICENSE__
 */

declare(strict_types=1);

namespace Lyrasoft\Sequence\Service;

use Lyrasoft\Sequence\Entity\Sequence;
use Windwalker\ORM\ORM;

/**
 * The SequenceService class.
 */
class SequenceService
{
    public function __construct(protected ORM $orm)
    {
    }

    public function getNextSerial(string $type, string $prefix): int
    {
        return $this->orm->getDb()->transaction(function () use ($prefix, $type) {
            $serial = $this->getCurrentFor($type, $prefix);

            if ($serial === null) {
                $serial = 1;
                // Create new row
                $this->orm->insert(Sequence::class)
                    ->columns('type', 'prefix', 'serial')
                    ->values([$type, $prefix, $serial])
                    ->execute();
            } else {
                $serial++;

                $this->orm->update(Sequence::class)
                    ->set('serial', $serial)
                    ->where('type', $type)
                    ->where('prefix', $prefix)
                    ->execute();
            }

            return $serial;
        });
    }

    public function getNextSerialAndPadZero(string $type, string $prefix, $length = 10): string
    {
        $serial = $this->getNextSerial($type, $prefix);

        return sprintf('%0' . $length . 'd', $serial);
    }

    public function getNextSerialWithPrefix(string $type, string $prefix, ?int $pad = null): string
    {
        if ($pad !== null) {
            $serial = $this->getNextSerialAndPadZero($type, $prefix, $pad);
        } else {
            $serial = $this->getNextSerial($type, $prefix);
        }

        return $prefix . $serial;
    }

    public function getCurrentFor(string $type, string $prefix): ?int
    {
        $current = $this->orm->select('serial')
            ->from(Sequence::class)
            ->where('type', $type)
            ->where('prefix', $prefix)
            ->forUpdate()
            ->result();

        if ($current === null) {
            return null;
        }

        return (int) $current;
    }
}
