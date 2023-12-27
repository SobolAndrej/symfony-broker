<?php

declare(strict_types=1);

namespace App\Command\User;

use App\Dispatcher\User\DecreaseBalanceMessageDispatcher;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'user:balance:decrease',
    description: 'This command creates a new message for User balance decrease.',
    hidden: false,
    aliases: ['u:b:d']
)]
class DecreaseBalanceMessageCommand extends Command
{
    private const ARGUMENT_USER_ID = 'userId';
    private const ARGUMENT_AMOUNT = 'amount';

    public function __construct(
        private DecreaseBalanceMessageDispatcher $messageDispatcher,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(self::ARGUMENT_USER_ID, InputArgument::REQUIRED, 'User ID')
            ->addArgument(self::ARGUMENT_AMOUNT, InputArgument::REQUIRED, 'How much should be minus from User balance')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $userId */
        $userId = $input->getArgument(self::ARGUMENT_USER_ID);
        /** @var string $amount */
        $amount = $input->getArgument(self::ARGUMENT_AMOUNT);

        $this->messageDispatcher->dispatch((int) $userId, (float) $amount);
        return Command::SUCCESS;
    }
}
