<?php declare(strict_types=1);

namespace App\Service\Rule\Contract;

use App\DTO\Transaction;

/**
 * Interface RuleInterface
 *
 * @package App\Service\Rule\Contract
 */
interface RuleInterface
{
    /**
     * @param Transaction $transaction
     */
    public function apply(Transaction $transaction): void;
}
