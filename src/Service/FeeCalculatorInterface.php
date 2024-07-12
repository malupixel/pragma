<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\LoanProposalInterface;

interface FeeCalculatorInterface
{
    /**
     * @return float The calculated total fee.
     */
    public function calculate(LoanProposalInterface $application): float;
}
