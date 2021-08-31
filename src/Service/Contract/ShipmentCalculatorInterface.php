<?php declare(strict_types=1);

namespace App\Service\Contract;

use App\DTO\Transaction;

/**
 * Interface ShipmentCalculatorService
 *
 * @package App\Service\Contract
 */
interface ShipmentCalculatorInterface
{
    /**
     * @param Transaction $transaction
     *
     * @return mixed
     */
    public function calculate(Transaction $transaction);
}
