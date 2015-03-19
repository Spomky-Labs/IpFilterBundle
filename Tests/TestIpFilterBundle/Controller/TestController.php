<?php

namespace SpomkyLabs\TestIpFilterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    public function indexAction()
    {
        return new Response('Hello world!');
    }
}
