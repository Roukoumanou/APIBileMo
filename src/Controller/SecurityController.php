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
     * @Doc\RequestBody(
     *      description= "You will need to fill in the fields: username and password",
     *      required= true,
     *      @Doc\JsonContent(
     *          example={
     *              "username": "bilmo@gmail.com",
     *              "password": "password"
     *          },
     *          @Doc\Schema(
     *              type="object",
     *              @Doc\Property(property="username", required=true, description="enter your email", type="string"),
     *              @Doc\Property(property="password", required=true, description="enter your password", type="string")
     *          )
     *      )
     * )
     */
    public function login()
    {
    }
}
