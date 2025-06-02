<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Attribute\Route;
use App\Service\Admin\StatsBoardService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class StatsBoardController extends AbstractController
{
    #[Route('/admin/stats/board', name: 'app_admin_stats_board')]
    public function index(StatsBoardService $statsBoardService): Response
    {
        $numberOfRecipients = $statsBoardService->getNumberOfRecipients();
        $numberOfNewslettersSent = $statsBoardService->numberOfSentNewsletters();

        return $this->render('admin/stats_board/index.html.twig', [
            'numberOfRecipients' => $numberOfRecipients,
            'numberOfNewslettersSent' => $numberOfNewslettersSent,
        ]);
    }
}
