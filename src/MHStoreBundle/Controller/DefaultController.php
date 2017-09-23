<?php

namespace MHStoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MHStoreBundle:Default:index.html.twig');
    }
}
