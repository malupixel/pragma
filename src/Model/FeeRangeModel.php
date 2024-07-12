<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\ValueObject\Fee;

final class FeeRangeModel
{
    public function __construct(
        private readonly Fee $from,
        private readonly Fee $to
    ) {}

    public function getTo(): Fee
    {
        return $this->to;
    }

    public function getFrom(): Fee
    {
        return $this->from;
    }

    public function getFeeForAmount(float $amount): ?float
    {
        if ($this->from->getAmount() > $amount || $this->to->getAmount() <= $amount) {
            return null;
        }

        $percent = ($amount - $this->from->getAmount()) / $this->getAmountRange();

        return round($this->from->getFee() + ($this->to->getFee() - $this->from->getFee()) * $percent, 2);
    }

    private function getAmountRange(): int
    {
        return $this->to->getAmount() - $this->from->getAmount();
    }
}