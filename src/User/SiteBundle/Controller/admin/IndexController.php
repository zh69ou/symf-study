<?php

namespace User\SiteBundle\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
/**
 * @Route("/admin/site")
 */
class IndexController extends Controller
{
    /**
     * @Route("/list/{page}", name="adsitelist", defaults={"page"="1"}, requirements={"page": "\d+"})
     */
    public function indexAction(Request $request,$page)
    {
    	$data['sites'] = $this->getDoctrine()->getRepository('UserSiteBundle:Site')->page($page);
    	$data['users'] = $this->getDoctrine()->getRepository('UserBaseBundle:User')->findAll();
        return $this->render('UserSiteBundle:Admin/Site:index.html.twig',$data);
    }
    /**
     * @Route("/edit/{id}", name="adsiteedit", requirements={"id": "\d+"})
     */
    public function editAction(Request $request,$id)
    {
    	$data['sites'] = $site = $this->getDoctrine()->getRepository('UserSiteBundle:Site')->find($id);
    	if($request->isMethod('post')&&$this->isCsrfTokenValid('adedsite', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('adedsite');
            $site->setName($request->request->get('name'));
            $site->setTitle($request->request->get('title'));
            $site->setKword($request->request->get('kword'));
            $site->setEndtime($request->request->get('endtime'));
            $site->setState($request->request->get('state'));
            $validator = $this->get('validator');
            $ersite = $validator->validate($site);
            if(count($ersite) == 0){
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($site);
                $manager->flush();
                $this->addFlash('success', 'editsuccess');
            }else{
                $this->addFlash('error', 'editerror');
            }
            return $this->redirectToRoute('adsitelist');
        }
        return $this->render('UserSiteBundle:Admin/Site:edit.html.twig',$data);
    }
    /**
     * @Route("/del/{id}", name="adsitedel", requirements={"id": "\d+"})
     */
    public function delAction(Request $request,$id)
    {
    	$site = $this->getDoctrine()->getRepository('UserSiteBundle:Sitepost')->findOne($id);
        if(!empty($site))
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($site);
            $manager->flush();
            $this->addFlash('error', 'delsuccess');
        }else{
            $this->addFlash('error', 'delerror');
        }
        return $this->redirectToRoute('adsitelist');
    }
}
