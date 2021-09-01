<?php declare(strict_types=1);

namespace App\Tests\Unit\DTO;

use App\DTO\Transaction;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class TransactionTest
 *
 * @package App\Tests\Unit\DTO
 */
class TransactionTest extends WebTestCase
{
    public function testTransaction()
    {
        $transaction = new Transaction('2015-02-07 L MR');

        $this->assertEquals($transaction->getSize(), 'L');
        $this->assertEquals($transaction->getProviderName(), 'MR');
        $this->assertEquals($transaction->getDiscount(), 0);
        $this->assertEquals($transaction->getShippingCost(), 0);
        $this->assertEquals($transaction->getDate(), new \DateTime('2015-02-07'));
    }
}
