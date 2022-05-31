<?php
namespace App\Controller;

use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
   /**
     * @Post(path="/api/login", name="login")
     */
    public function login()
    {
    }
}
