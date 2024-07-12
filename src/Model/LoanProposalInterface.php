<?php

namespace App\Model;

interface LoanProposalInterface
{
    public function term(): int;
    public function amount(): float;
}