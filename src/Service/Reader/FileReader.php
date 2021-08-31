<?php declare(strict_types=1);

namespace App\Service\Reader;

use App\Service\Reader\Contract\ReaderInterface;
use Exception;

/**
 * Class FileReader
 *
 * @package App\Service\Reader
 */
class FileReader implements ReaderInterface
{
    /**
     * @var string $filePath
     */
    private string $filePath;

    private $stream;

    /**
     * FileReader constructor.
     *
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return bool|mixed|string
     * @throws \Exception
     */
    public function read()
    {
        return $this->streamFileContent($this->filePath);
    }

    /**
     * @param string $filePath
     *
     * @return bool|string
     * @throws \Exception
     */
    private function streamFileContent(string $filePath)
    {
        if(!$this->stream) {
            $this->stream = $this->openFile($filePath);
        }

        if ($this->stream && ($line = fgets($this->stream))) {
            return trim($line);
        }

        fclose($this->stream);

        return false;
    }

    /**
     * @param string $filePath
     *
     * @return ReaderInterface
     */
    public function setFilePath(string $filePath): ReaderInterface
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * @param string $filePath
     *
     * @return false|resource
     * @throws \Exception
     */
    private function openFile(string $filePath)
    {
        $this->stream = fopen($filePath, 'r');

        if (false === $this->stream) {
            throw new Exception('Unable to open file for read: ' . $filePath);
        }

        return $this->stream;
    }
}
