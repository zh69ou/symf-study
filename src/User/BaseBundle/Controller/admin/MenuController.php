<?php

namespace User\BaseBundle\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use User\BaseBundle\Entity\Menulist;

/**
 * @Route("/admin/menu")
 */
class MenuController extends Controller
{
	/**
     * @Route("/list/{page}", name="amenulist", defaults={"page"="1"}, requirements={"page": "\d+"})
     */
    public function amenulist(Request $request,$page)
    {
    	$data['menus']=$this->getDoctrine()->getRepository('UserBaseBundle:Menulist')->page($page);
        return $this->render('UserBaseBundle:Admin:menulist.html.twig',$data);
    }
	/**
     * @Route("/edit/{id}", name="amenuedit", requirements={"id": "\d+"})
     */
    public function amenuedit(Request $request,$id)
    {
        $menu = $this->getDoctrine()->getRepository('UserBaseBundle:Menulist')->find($id);
    	if($request->isMethod('post')&&$this->isCsrfTokenValid('admenups', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('admenups');
            if(!empty($menu)){
            	$menu->setName($request->request->get('name'));
	            $menu->setUrl($request->request->get('url'));
	            $menu->setTitle($request->request->get('title'));
	            $menu->setKword($request->request->get('kword'));
	            $menu->setSort($request->request->get('sort'));
	            $menu->setState($request->request->get('state'));

	            $validator = $this->get('validator');
	            $error = $validator->validate($menu);
	            if(count($error) == 0)
	            {
	                $manager = $this->getDoctrine()->getManager();
	                $manager->persist($menu);
	                $manager->flush();
	                $this->addFlash('success', 'editsuccess');
	                return $this->redirectToRoute('amenulist');
	            }
            }
            $this->addFlash('error', 'editerror');
        }
        $data['menu']=$menu;
        $data['act']='edit';
        return $this->render('UserBaseBundle:Admin:menuinfo.html.twig',$data);
    }
	/**
     * @Route("/add", name="amenuadd")
     */
    public function amenuadd(Request $request)
    {
    	if($request->isMethod('post')&&$this->isCsrfTokenValid('admenups', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('admenups');
            $menu = $this->getDoctrine()->getRepository('UserBaseBundle:Menulist')->findOneBy(array('name'=>$request->request->get('name')));
            if(empty($menu))
            {
                $menu = new Menulist();
                $menu->setName($request->request->get('name'));
                $menu->setUrl($request->request->get('url'));
                $menu->setTitle($request->request->get('title'));
                $menu->setKword($request->request->get('kword'));
                $menu->setSort($request->request->get('sort'));
                $menu->setState($request->request->get('state'));

                $validator = $this->get('validator');
                $error = $validator->validate($menu);
                if(count($error) == 0)
                {
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($menu);
                    $manager->flush();
                    $this->addFlash('success', 'addsuccess');
                    return $this->redirectToRoute('amenulist');
                }
            }
            $this->addFlash('error', 'adderror');
        }
        $data['act']='add';
        return $this->render('UserBaseBundle:Admin:menuinfo.html.twig',$data);
    }
	/**
     * @Route("/del/{id}", name="amenudel", requirements={"id": "\d+"})
     */
    public function amenudel(Request $request,$id)
    {
        $menu = $this->getDoctrine()->getRepository('UserBaseBundle:Menulist')->find($id);
        if(!empty($menu))
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($menu);
            $manager->flush();
            $this->addFlash('success', 'delsuccess');
        }else{
            $this->addFlash('error', 'delerror');
        }
        return $this->redirectToRoute('amenulist');
    }
}