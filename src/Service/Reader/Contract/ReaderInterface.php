<?php

declare(strict_types=1);

namespace App\Service\Reader\Contract;

/**
 * Interface ReaderInterface
 *
 * @package App\Service\Reader\Contract
 */
interface ReaderInterface
{
    /**
     * @return mixed
     */
    public function read();

    /**
     * @param string $filePath
     *
     * @return $this
     */
    public function setFilePath(string $filePath): self;
}
