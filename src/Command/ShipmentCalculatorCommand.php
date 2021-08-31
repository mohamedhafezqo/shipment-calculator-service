<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\Contract\ShipmentCalculatorInterface;
use App\Service\Reader\Contract\ReaderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ShipmentCalculatorCommand
 *
 * @package App\Command
 */
class ShipmentCalculatorCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'shipment-discount:calculate';

    protected array $input;

    protected ReaderInterface $reader;

    protected ShipmentCalculatorInterface $shipmentCalculator;

    /**
     * ShipmentCalculatorCommand constructor.
     *
     * @param ReaderInterface $reader
     * @param ShipmentCalculatorInterface $shipmentCalculator
     */
    public function __construct(ReaderInterface $reader, ShipmentCalculatorInterface $shipmentCalculator)
    {
        $this->reader = $reader;
        $this->shipmentCalculator = $shipmentCalculator;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->shipmentCalculator->calculateBulk($this->reader) as $value) {
            $output->writeln($value);
        }

        return 0;
    }
}
