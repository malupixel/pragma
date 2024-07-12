<?php

namespace App\Tests\Unit\Service;

use App\Model\LoanProposal;
use App\Service\FeeCalculator;
use PHPUnit\Framework\TestCase;

class FeeCalculatorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @param int $term
     * @param float $amount
     * @param float $result
     * @return void
     */
    public function testCalculate(int $term, float $amount, float $result): void
    {
        $calculator = new FeeCalculator();
        $fee = $calculator->calculate(new LoanProposal(term: $term, amount: $amount));
        $this->assertEquals(expected: $result, actual: $fee);
    }

    public function dataProvider(): array
    {
        return [
            [12, 1200, 60],
            [12, 8987.12, 182.88],
            [24, 8435.12, 339.88],
            [24, 15345.20, 614.8]
        ];
    }
}