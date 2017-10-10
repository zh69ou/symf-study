<?php

namespace Index\BaseBundle\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin/sets")
 */
class SetsController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('IndexBaseBundle:Admin:index.html.twig');
    }
}
