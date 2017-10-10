<?php

namespace User\BaseBundle\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use User\BaseBundle\Entity\User;

/**
 * @Route("/admin/user")
 */
class IndexController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('UserBaseBundle:Admin:index.html.twig');
    }

    /**
     * @Route("/list/{page}", name="auserlist", defaults={"page"="1"}, requirements={"page": "\d+"})
     */
    public function aduserlist(Request $request,$page)
    {
    	$data['users']=$this->getDoctrine()->getRepository('UserBaseBundle:User')->page($page);
        return $this->render('UserBaseBundle:Admin:auserlist.html.twig',$data);
    }

    /**
     * @Route("/edit/{id}", name="aduseredit", requirements={"id": "\d+"})
     */
    public function aduseredit(Request $request,$id)
    {
    	$data['info']=$user=$this->getDoctrine()->getRepository('UserBaseBundle:User')->find($id);
        if($request->isMethod('post')&&$this->isCsrfTokenValid('edituserps', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('edituserps');
            if(empty($user)){
                $this->addFlash('error', 'editerror');
            }else{
                $user->setUsername($request->request->get('username'));
                $user->setPhone($request->request->get('phone'));
                $user->setEmail($request->request->get('email'));
                $user->setApprove($request->request->get('approve'));
                $user->setState($request->request->get('state'));
                if(!empty($request->request->get('password'))&&$request->request->get('password')==$request->request->get('password')){
                    $encoder = $this->container->get('security.password_encoder');
                    $user->setPassword($encoder->encodePassword($user,md5($request->request->get('password'))));
                }
                $validator = $this->get('validator');
                $eruser = $validator->validate($user);
                if(count($eruser) == 0){
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($user);
                    $manager->flush();
                    $this->addFlash('success', 'editsuccess');
                }else{
                    $this->addFlash('error', 'editerror');
                }
            }
            return $this->redirectToRoute('auserlist');
        }
    	return $this->render('UserBaseBundle:Admin:auseredit.html.twig',$data);
    }

    /**
     * @Route("/del/{id}", name="aduserdel", requirements={"id": "\d+"})
     */
    public function aduserdel()
    {
        $user = $this->getDoctrine()->getRepository('UserBaseBundle:Sitepost')->findOne($id);
        if(!empty($user))
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($user);
            $manager->flush();
            $this->addFlash('error', 'delsuccess');
        }else{
            $this->addFlash('error', 'delerror');
        }
        return $this->redirectToRoute('auserlist');
    }
}
