<?php

declare(strict_types=1);

namespace App\Command\User;

use App\Dispatcher\User\TransferBalanceMessageDispatcher;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'user:balance:transfer',
    description: 'This command creates a new message for balance transfer from one User to another one.',
    hidden: false,
    aliases: ['u:b:t']
)]
class TransferBalanceMessageCommand extends Command
{
    private const ARGUMENT_FROM_USER_ID = 'fromUserId';
    private const ARGUMENT_TO_USER_ID = 'toUserId';
    private const ARGUMENT_AMOUNT = 'amount';

    public function __construct(
        private TransferBalanceMessageDispatcher $messageDispatcher,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(self::ARGUMENT_FROM_USER_ID, InputArgument::REQUIRED, 'From User ID')
            ->addArgument(self::ARGUMENT_TO_USER_ID, InputArgument::REQUIRED, 'To User ID')
            ->addArgument(
                self::ARGUMENT_AMOUNT,
                InputArgument::REQUIRED,
                'How much should be transfer from user ot user'
            )
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $fromUserId */
        $fromUserId = $input->getArgument(self::ARGUMENT_FROM_USER_ID);
        /** @var string $toUserId */
        $toUserId = $input->getArgument(self::ARGUMENT_TO_USER_ID);
        /** @var string $amount */
        $amount = $input->getArgument(self::ARGUMENT_AMOUNT);

        $this->messageDispatcher->dispatch((int) $fromUserId, (int) $toUserId, (float) $amount);
        return Command::SUCCESS;
    }
}
