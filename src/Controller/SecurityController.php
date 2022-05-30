<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /**
     * @Post(path="/api/login", name="login_check")
     */
   public function login(): Response
   {
        return $this->json([
            'message' => 'Bienvenu',
            'path' => 'src/Controller/SecurityController.php'
        ]);
   }
}
