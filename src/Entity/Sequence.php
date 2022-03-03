<?php

/**
 * Part of starter project.
 *
 * @copyright  Copyright (C) 2021 __ORGANIZATION__.
 * @license    __LICENSE__
 */

declare(strict_types=1);

namespace Lyrasoft\Sequence\Entity;

use Windwalker\ORM\Attributes\Column;
use Windwalker\ORM\Attributes\EntitySetup;
use Windwalker\ORM\Attributes\PK;
use Windwalker\ORM\Attributes\Table;
use Windwalker\ORM\EntityInterface;
use Windwalker\ORM\EntityTrait;
use Windwalker\ORM\Metadata\EntityMetadata;

/**
 * The Sequence class.
 */
#[Table('sequences', 'sequence')]
class Sequence implements EntityInterface
{
    use EntityTrait;

    #[Column('type'), PK]
    protected string $type = '';

    #[Column('prefix'), PK]
    protected string $prefix = '';

    #[Column('serial')]
    protected int $serial = 0;

    #[EntitySetup]
    public static function setup(EntityMetadata $metadata): void
    {
        //
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    public function setPrefix(string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getSerial(): int
    {
        return $this->serial;
    }

    public function setSerial(int $serial): static
    {
        $this->serial = $serial;

        return $this;
    }
}
