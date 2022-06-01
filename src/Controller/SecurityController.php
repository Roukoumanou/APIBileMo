<?php
namespace App\Controller;

use OpenApi\Annotations as Doc;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
   /**
     * @Post(path="/api/login", name="login")
     * @Doc\Response(
     *      response=200,
     *      description="This is the URI that allows you to log in to get a token"
     * )
     */
    public function login()
    {
    }
}
