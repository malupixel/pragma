<?php

namespace App\Service;

use App\Model\FeeRangeModel;
use App\Model\LoanProposalInterface;
use App\Model\ValueObject\Fee;

final class FeeCalculator implements FeeCalculatorInterface
{
    const FEES = [
        12 => [
            1000 => 50,
            2000 => 90,
            3000 => 90,
            4000 => 115,
            5000 => 100,
            6000 => 120,
            7000 => 140,
            8000 => 160,
            9000 => 180,
            10000 => 200,
            11000 => 220,
            12000 => 240,
            13000 => 260,
            14000 => 280,
            15000 => 300,
            16000 => 320,
            17000 => 340,
            18000 => 360,
            19000 => 380,
            20000 => 400,
        ],
        24 => [
            1000 => 70,
            2000 => 100,
            3000 => 120,
            4000 => 160,
            5000 => 200,
            6000 => 240,
            7000 => 280,
            8000 => 320,
            9000 => 360,
            10000 => 400,
            11000 => 440,
            12000 => 480,
            13000 => 520,
            14000 => 560,
            15000 => 600,
            16000 => 640,
            17000 => 680,
            18000 => 720,
            19000 => 760,
            20000 => 800,
        ],
    ];
    const ROUND_PRECISION = 5;

    /**
     * @inheritDoc
     */
    public function calculate(LoanProposalInterface $application): float
    {
        return $this->getRoundedFee(
            fee: $this->getFeeRange($application)->getFeeForAmount($application->amount()),
            amount: $application->amount(),
            precision: self::ROUND_PRECISION
        );
    }

    private function getFeeRange(LoanProposalInterface $loanProposal): FeeRangeModel
    {
        $from = null;
        $to = null;
        foreach (self::FEES[$loanProposal->term()] as $amount => $fee) {
            if ($amount <= $loanProposal->amount()) {
                $from = new Fee(amount: $amount, fee: $fee, term: $loanProposal->term());
                continue;
            }
            if ($to === null) {
                $to = new Fee(amount: $amount, fee: $fee, term: $loanProposal->term());
                break;
            }
        }
        if ($to === null) {
            $to = $from;
        }

        return new FeeRangeModel(from: $from, to: $to);
    }

    private function getRoundedFee(float $fee, float $amount, int $precision = 5): float
    {
        return $fee + round(($precision - fmod($fee + $amount, $precision)), 2);
    }
}