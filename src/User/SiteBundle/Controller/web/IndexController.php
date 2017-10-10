<?php

namespace User\SiteBundle\Controller\web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/{web}/site", defaults={"web"="index"}, requirements={"web":"(?!admin)\w+"})
 */
class IndexController extends Controller
{
    /**
     * @Security("has_role(web~'_webset')")
     * @Route("/", name="s_index")
     */
    public function indexAction(Request $request,$web)
    {
		if($request->isMethod('post')&&$this->isCsrfTokenValid('upsite', $request->request->get('_token')))
		{
            $this->container->get('security.csrf.token_manager')->removeToken('upsite');
			$site = $this->getDoctrine()->getRepository('UserSiteBundle:Site')->findOneByName($web);
			$site->setTitle($request->request->get('title'));
			$site->setKword($request->request->get('kword'));
            $site->setMenuls($request->request->get('mls'));
			$validator = $this->get('validator');
    		$errors = $validator->validate($site);
    		if(count($errors) == 0)
    		{
    			$manager = $this->getDoctrine()->getManager();
    			$manager->persist($site);
				$manager->flush();
    			$this->addFlash('success', 'site.act_true');
    		}else{
				$this->addFlash('error', 'site.act_false');
			}
		}
        $data['fodders'] = $this->getDoctrine()->getRepository('UserSiteBundle:Fodder')->findBy(array('site'=>$web,'type'=>'img','state'=>1),array('id'=>'desc'));
        $data['menu'] = $this->getDoctrine()->getRepository('UserBaseBundle:Menulist')->findBy(array('state'=>1),array('id'=>'desc'));
        return $this->render('UserSiteBundle:Web:index.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'_weblist')")
     * @Route("/weblist", name="weblist")
     */
    public function weblist()
    {
        $data['sites'] = $this->getDoctrine()->getRepository('UserSiteBundle:Site')->findByUid($this->getUser()->getId());
        $data['usites'] = $this->getDoctrine()->getRepository('UserSiteBundle:Siteuser')->findByUid($this->getUser()->getId());
        return $this->render('UserSiteBundle:Web:weblist.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'_indexset')")
     * @Route("/fiset", name="fiset")
     */
    public function fiset(Request $request,$web)
    {
        $site = $this->getDoctrine()->getRepository('UserSiteBundle:Site')->findOneByName($web);
        if($request->isMethod('post')&&$this->isCsrfTokenValid('uindexset', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('uindexset');
            $site->setSetcon($request->request->get('setc'));
            $validator = $this->get('validator');
            $errors = $validator->validate($site);
            if(count($errors) == 0)
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($site);
                $manager->flush();
                $this->addFlash('success', 'site.act_true');
            }else{
                $this->addFlash('error', 'site.act_false');
            }
        }
        // echo '<pre>';var_dump($site->getSetcon());exit;
        $data['site']=$site;
        $data['fodders'] = $this->getDoctrine()->getRepository('UserSiteBundle:Fodder')->findBy(array('site'=>$web,'type'=>'img','state'=>1),array('id'=>'desc'));
        $data['menu'] = $this->getDoctrine()->getRepository('UserBaseBundle:Menulist')->findBy(array('state'=>1),array('id'=>'desc'));
        return $this->render('UserSiteBundle:Web/Sets:fiset.html.twig',$data);
    }
}
