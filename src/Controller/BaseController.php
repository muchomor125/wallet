<?php
declare(strict_types=1);
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class BaseController extends AbstractController
{
    /**
     * @Route("/panel", name="panel")
     */
    public function panel(): Response
    {
        return $this->render(
            'panel/panel.html.twig'
        );
    }
}
