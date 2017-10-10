<?php

namespace Index\BaseBundle\Controller\web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

// use Admin\BaseBundle\Entity\Aduser;
// use User\BaseBundle\Entity\User;
// use User\SiteBundle\Entity\Site;
// use User\SiteBundle\Entity\Fodder;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        // $fodder = $this->getDoctrine()->getRepository('UserSiteBundle:Fodder')->findOneBy(array('site'=>'index','id'=>'1'));
        // var_dump($fodder);exit;
        return $this->render('IndexBaseBundle:Web:index.html.twig');
    }

    // 测试方法
    //@Route("/help/upsql", name="upsql")
    // public function upsql()
    // {
    //   $ausers = $this->getDoctrine()->getRepository('AdminBaseBundle:Aduser');
    //     if(empty($ausers->findOneBy(array('username'=>'admin'))))
    //     {
    //         $auser = new Aduser();
    //         $auser->setUsername('admin');
    //         $auser->setEmail('zhou69.1@eyou.com');
    //         $auser->setPhone('18680885691');
    //         $auser->setHimg('');
    //         $auser->setRegtime();
    //         $auser->setState(1);
    //         $auser->setRoles(array('ROLE_ADMIN'));
    //         $encoder = $this->container->get('security.password_encoder');
    //         $auser->setPassword($encoder->encodePassword($auser,'123456'));
    //         $manager = $this->getDoctrine()->getManager();
    //         $manager->persist($auser);
    //         $manager->flush();
    //     }
    //   $users = $this->getDoctrine()->getRepository('UserBaseBundle:User');
    //     if(empty($users->findOneBy(array('username'=>'user'))))
    //     {
    //         $user = new User();
    //         $user->setUsername('user');
    //         $user->setEmail('zhou69.1@qq.com');
    //         $user->setPhone('18680885691');
    //         $user->setHimg('');
    //         $user->setRegtime();
    //         $user->setApprove(1);
    //         $user->setState(1);
    //         $user->setRoles(array("ROLE_USER","index_webset","index_indexset","index_navset","index_fodderlist","index_fodderadd","index_fodderdel","index_sueradd","index_suserup","index_suserdel","index_suserclist","index_suserslist","index_suserllist","index_suserzlist","index_suserplist"));
    //         $encoder = $this->container->get('security.password_encoder');
    //         $user->setPassword($encoder->encodePassword($user,'123456'));
    //         $manager = $this->getDoctrine()->getManager();
    //         $manager->persist($user);
    //         $manager->flush();
    //     }
    // 	$sites = $this->getDoctrine()->getRepository('UserSiteBundle:Site');
    //     if(empty($sites->findOneBy(array('name'=>'index'))))
    //     {
    //         $site = new Site();
    //       	$site->setName('index');
    //       	$site->setUid(1);
    //       	$site->setTitle('INDEX');
    //       	$site->setKword('INDEX');
    //       	$site->setEndtime('2099-12-31');
    //       	$site->setState(1);
    //   			$manager = $this->getDoctrine()->getManager();
    //   			$manager->persist($site);
    //   			$manager->flush();
    //     }
    //     exit;
    // }
}
