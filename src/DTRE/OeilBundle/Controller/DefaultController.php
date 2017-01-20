<?php

namespace DTRE\OeilBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DTREOeilBundle:Default:index.html.twig');
    }
}
