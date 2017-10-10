<?php

namespace User\ToolBundle\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use User\ToolBundle\Entity\Tool;
/**
 * @Route("/admin/tool")
 */
class IndexController extends Controller
{
    /**
     * @Route("/list/{page}", name="adtoollist", defaults={"page"="1"}, requirements={"page": "\d+"})
     */
    public function indexAction(Request $request,$page)
    {
    	$data['tools'] = $this->getDoctrine()->getRepository('UserToolBundle:Tool')->page($page);
        return $this->render('UserToolBundle:Admin:list.html.twig',$data);
    }
    /**
     * @Route("/add/", name="adtooladd")
     */
    public function adtooladd(Request $request)
    {
        if($request->isMethod('post')&&$this->isCsrfTokenValid('adtoolps', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('adtoolps');
            $tool = $this->getDoctrine()->getRepository('UserToolBundle:Tool')->findOneBy(array('codenum'=>$request->request->get('codenum')));
            if(empty($tool))
            {
                $tool = new Tool();
                $tool->setCodenum($request->request->get('codenum'));
                $tool->setCplist($request->request->get('cplist'));
                $tool->setName($request->request->get('name'));
                $tool->setKword($request->request->get('kword'));
                $tool->setDword($request->request->get('dword'));
                $tool->setContent($request->request->get('content'));
                $tool->setPrice($request->request->get('price'));
                $tool->setSort($request->request->get('sort'));
                $tool->setRecommend($request->request->get('recommend'));
                $tool->setState($request->request->get('state'));

                $validator = $this->get('validator');
                $error = $validator->validate($tool);
                if(count($error) == 0)
                {
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($tool);
                    $manager->flush();
                    $this->addFlash('success', 'addsuccess');
                    return $this->redirectToRoute('adtoollist');
                }
            }
            $this->addFlash('error', 'adderror');
        }
        return $this->render('UserToolBundle:Admin:tooladd.html.twig');
    }
    /**
     * @Route("/edit/{id}", name="adtooledit", requirements={"id": "\d+"})
     */
	public function adtooledit(Request $request,$id)
	{
        $data['tool'] = $tool = $this->getDoctrine()->getRepository('UserToolBundle:Tool')->find($id);
        if($request->isMethod('post')&&$this->isCsrfTokenValid('adtoolps', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('adtoolps');
            if(!empty($tool))
            {
            	$tool->setCodenum($request->request->get('codenum'));
            	$tool->setCplist($request->request->get('cplist'));
            	$tool->setName($request->request->get('name'));
            	$tool->setKword($request->request->get('kword'));
            	$tool->setDword($request->request->get('dword'));
            	$tool->setContent($request->request->get('content'));
            	$tool->setPrice($request->request->get('price'));
            	$tool->setSort($request->request->get('sort'));
            	$tool->setRecommend($request->request->get('recommend'));
            	$tool->setState($request->request->get('state'));

	            $validator = $this->get('validator');
	            $error = $validator->validate($tool);
	            if(count($error) == 0)
	            {
	                $manager = $this->getDoctrine()->getManager();
	                $manager->persist($tool);
	                $manager->flush();
	                $this->addFlash('success', 'editsuccess');
            		return $this->redirectToRoute('adtoollist');
	            }
            }
    		$this->addFlash('error', 'editerror');
        }
		return $this->render('UserToolBundle:Admin:tooledit.html.twig',$data);
	}
}
