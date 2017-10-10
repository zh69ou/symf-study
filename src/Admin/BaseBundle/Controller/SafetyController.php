<?php

namespace Admin\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Admin\BaseBundle\Entity\Aduser;
use User\SiteBundle\Entity\Site;
/**
 * @Route("/admin")
 */
class SafetyController extends Controller
{
	/**
     * @Route("/adlogin", name="ad_login")
     */
	public function login()
	{
		return $this->render('AdminBaseBundle:sole:login.html.twig');
	}

	/**
     * @Route("/adland", name="ad_land")
     */
	public function land()
	{
		throw new \Exception('This should never be reached!');
	}

	/**
     * @Route("/adlogout", name="ad_logout")
     */
	public function logout()
	{
		throw new \Exception('This should never be reached!');
	}

	/**
     * @Route("/adnodenied", name="adnodenied")
     */
	public function adnodenied()
	{
		return $this->render('AdminBaseBundle:sole:nodenied.html.twig');
	}

}
