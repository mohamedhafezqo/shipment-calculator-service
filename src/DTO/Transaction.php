<?php declare(strict_types=1);

namespace App\DTO;

/**
 * Class Transaction
 *
 * @package App\DTO
 */
class Transaction
{
    private string $providerName;

    private string $size;

    private \DateTimeImmutable $date;

    private float $shippingCost;

    private float $discount;

    /**
     * Transaction constructor.
     *
     * @param string $line
     *
     * @throws \Exception
     */
    public function __construct(string $line = '')
    {
        $this->parse($line);
    }

    public function parse(string $line): self
    {
        if (!$line) {
            return $this;
        }

        $transaction = explode(' ', $line);
            $this->date = new \DateTimeImmutable($transaction[0]);
        $this->providerName = $transaction[2] ?? 'Ignored';
        $this->size = $transaction[1];
        $this->shippingCost = 0.00;
        $this->discount = 0.00;

        return $this;
    }

    /**
     * @return string
     */
    public function getProviderName(): string
    {
        return $this->providerName;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return float
     */
    public function getShippingCost(): float
    {
        return $this->shippingCost;
    }

    /**
     * @param float $shippingCost
     *
     * @return $this
     */
    public function setShippingCost(float $shippingCost)
    {
        $this->shippingCost = $shippingCost;

        return $this;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     *
     * @return $this
     */
    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @param float $discount
     *
     * @return float
     */
    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $text = '';
        $text .= $this->date->format('Y-m-d') . " ";
        $text .= $this->size . " ";
        $text .= $this->providerName . " ";
        $text .= $this->shippingCost . " ";
        $text .= $this->discount ? $this->discount : '-' . " ";

        return $text;
    }
}
