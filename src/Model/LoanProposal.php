<?php

declare(strict_types=1);

namespace App\Model;

final class LoanProposal implements LoanProposalInterface
{
    private int $term;

    private float $amount;

    public function __construct(int $term, float $amount)
    {
        $this->term = $term;
        $this->amount = $amount;
    }

    public function term(): int
    {
        return $this->term;
    }

    public function amount(): float
    {
        return $this->amount;
    }
}
