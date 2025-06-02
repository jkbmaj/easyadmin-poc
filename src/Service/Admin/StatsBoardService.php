<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Repository\MessageSentRepository;
use App\Repository\RecipientRepository;

class StatsBoardService
{
    public function __construct(
        private readonly RecipientRepository $recipientRepository,
        private readonly MessageSentRepository $messageSentRepository,
    ) {
    }

    public function getNumberOfRecipients(): int
    {
        return count($this->recipientRepository->findAll());
    }

    public function numberOfSentNewsletters(): int
    {
        return count($this->messageSentRepository->findAll());
    }
}
