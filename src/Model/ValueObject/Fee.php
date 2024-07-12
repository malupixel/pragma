<?php

namespace App\Model\ValueObject;

final class Fee
{
    public function __construct(
        private readonly int $amount,
        private readonly int $fee,
        private readonly ?int $term = null
    ) {}

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getFee(): int
    {
        return $this->fee;
    }

    public function getTerm(): ?int
    {
        return $this->term;
    }
}