<?php

namespace User\ToolBundle\Controller\web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use User\ToolBundle\Entity\Toolbuy;

/**
 * @Route("/{web}/tool", defaults={"web"="index"}, requirements={"web":"(?!admin)\w+"})
 */
class IndexController extends Controller
{
	/**
     * @Route("/atoollist/{page}", name="atoollist", defaults={"page"="1"}, requirements={"page": "\d+"})
     */
	public function atoollist(Request $request,$web,$page)
	{
		$data['toollist'] = $this->getDoctrine()->getRepository('UserToolBundle:Tool')->page($page);
		$data['toolsite'] = $this->getDoctrine()->getRepository('UserToolBundle:Toolsite')->findBySite($web);
		return $this->render('UserToolBundle:Web/Tool:list.html.twig',$data);
	}

	/**
     * @Route("/atooladd/{code}", name="atooladd", requirements={"code": "\w+"})
     */
	public function atooladd(Request $request,$web,$code)
	{
		$data['info'] = $this->getDoctrine()->getRepository('UserToolBundle:Tool')->findOneByCodenum($code);
		if($request->isMethod('post')&&$this->isCsrfTokenValid('atoolts', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('atoolts');
            $toolbuy = $this->getDoctrine()->getRepository('UserToolBundle:Toolbuy')->findOneBy(array('tool'=>$code,'site'=>$web),array('id'=>'DESC'));
            if(empty($toolbuy)||$toolbuy->getEtime()<$request->request->get('btime'))
            {
            	$tbuy = new Toolbuy();
            	$tbuy->setTool($code);
            	$tbuy->setSite($web);
            	$tbuy->setBtime($request->request->get('btime'));
            	$tbuy->setEtime($request->request->get('etime'));
            	$tbuy->setAtime();

	            $validator = $this->get('validator');
	            $eruser = $validator->validate($tbuy);
	            if(count($eruser) == 0)
	            {
	                $manager = $this->getDoctrine()->getManager();
	                $manager->persist($tbuy);
	                $manager->flush();
	                $this->addFlash('success', 'tool.act_true');
	            }else{
            		$this->addFlash('error', 'tool.act_false');
	            }
            }
            return $this->redirectToRoute('atoollist',array('web'=>$web));
        }
		return $this->render('UserToolBundle:Web/Tool:add.html.twig',$data);
	}
}
