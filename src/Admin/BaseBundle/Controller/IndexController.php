<?php

namespace Admin\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin")
 */
class IndexController extends Controller
{
    /**
     * @Route("/", name="adindex")
     */
    public function indexAction()
    {
        return $this->render('AdminBaseBundle:sole:index.html.twig');
    }
    /**
     * @Route("/info", name="adinfo")
     */
    public function adinfo()
    {
        return $this->render('AdminBaseBundle:sole:info.html.twig');
    }
}
