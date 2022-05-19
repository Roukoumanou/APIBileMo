<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login_check", name="login_check", methods={"POST"})
     */
   public function login(): Response
   {
    return $this->json([
        'message' => 'Bienvenu',
        'path' => 'src/Controller/SecurityController.php'
    ]);
   }
}
