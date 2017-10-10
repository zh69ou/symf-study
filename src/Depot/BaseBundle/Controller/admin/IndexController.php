<?php

namespace Depot\BaseBundle\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin/depot")
 */
class IndexController extends Controller
{
    /**
     * @Route("/", name="addepot")
     */
    public function indexAction()
    {
        return $this->render('DepotBaseBundle:Admin:index.html.twig');
    }
}
