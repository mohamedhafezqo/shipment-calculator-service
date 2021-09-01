<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Transaction;
use App\Service\Contract\ShipmentCalculatorInterface;
use App\Service\Reader\Contract\ReaderInterface;
use App\Service\Rule\Contract\RuleInterface;

/**
 * Class ShipmentCalculatorService
 *
 * @package App\Service
 */
class ShipmentCalculatorService implements ShipmentCalculatorInterface
{
    private iterable $rules;

    /**
     * ShipmentCalculatorService constructor.
     *
     * @param iterable $rules
     */
    public function __construct(iterable $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @return Transaction
     */
    public function calculate(Transaction $transaction): Transaction
    {
        foreach ($this->rules as $rule) {
            $rule->apply($transaction);
        }

        return $transaction;
    }

    /**
     * @param ReaderInterface $reader
     *
     * @return \Iterator
     * @throws \Exception
     */
    public function calculateBulk(ReaderInterface $reader): \Iterator
    {
        $transaction = new Transaction();

        while ($line = $reader->read()) {
            $transaction->parse($line);

            yield $this->calculate($transaction);
        }
    }
}
