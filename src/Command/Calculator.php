<?php

namespace App\Command;

use App\Model\LoanProposal;
use App\Service\FeeCalculatorInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:calculator:calculate',
    description: 'Calculate fee',
    aliases: ['app:calculate-fee'],
    hidden: false
)]
final class Calculator extends Command
{
    const ALLOW_TERMS = [12, 24];
    const MIN_AMOUNT = 1000;
    const MAX_AMOUNT = 20000;
    public function __construct(
        private readonly FeeCalculatorInterface $calculator,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Wyliczanie prowizji');

        $helper = $this->getHelper('question');
        do {
            $question = new Question('Podaj kwotę:');
            $amount = round((float)$helper->ask($input, $output, $question), 2);
        } while ($amount < self::MIN_AMOUNT || $amount > self::MAX_AMOUNT);

        do {
            $question = new Question('Podaj liczbę miesięcy (12/24):');
            $term = (int)$helper->ask($input, $output, $question);
        } while (!in_array($term, self::ALLOW_TERMS));
        $fee = $this->calculator->calculate(new LoanProposal(term: $term, amount: $amount));

        $io->success(sprintf('Prowizja wynosi %s, natomiast koszt całkowity %s', $fee, $amount + $fee));

        return 1;
    }
}