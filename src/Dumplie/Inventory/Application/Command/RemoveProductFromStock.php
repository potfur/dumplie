<?php

declare (strict_types = 1);

namespace Dumplie\Inventory\Application\Command;

use Dumplie\SharedKernel\Application\Command\Command;
use Dumplie\SharedKernel\Application\Command\CommandSerialize;

final class RemoveProductFromStock implements Command
{
    use CommandSerialize;

    /**
     * @var string
     */
    private $sku;

    /**
     * RemoveProductFromStock constructor.
     *
     * @param string $sku
     */
    public function __construct(string $sku)
    {
        $this->sku = $sku;
    }

    /**
     * @return string
     */
    public function sku(): string
    {
        return $this->sku;
    }
}
