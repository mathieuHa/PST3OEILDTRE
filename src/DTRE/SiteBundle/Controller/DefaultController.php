<?php

namespace DTRE\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DTRESiteBundle:Default:index.html.twig');
    }
}
