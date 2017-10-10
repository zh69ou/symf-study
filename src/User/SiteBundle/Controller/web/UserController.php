<?php

namespace User\SiteBundle\Controller\web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use User\SiteBundle\Entity\Sitepost;
use User\SiteBundle\Entity\Siteuser;
use User\BaseBundle\Entity\User;

/**
 * @Route("/{web}/user", defaults={"web"="index"}, requirements={"web":"(?!admin)\w+"})
 */
class UserController extends Controller
{
    /**
     * @Security("has_role(web~'_suserplist')")
     * @Route("/userpower/{id}", name="userpower", requirements={"id": "\d+"})
     */
    public function userpower(Request $request,$web,$id)
    {
        $data['info'] = $suser = $this->getDoctrine()->getRepository('UserSiteBundle:Siteuser')->findOneBy(array('site'=>$web,'id'=>$id));
        if(empty($suser)||$suser->getUser()->getId()==$this->getUser()->getId())
        {
            $this->addFlash('error', 'suser.act_false');
            return $this->redirectToRoute('suserlist',array('web'=>$web,'state'=>2));
        }
        if($request->isMethod('post')&&$this->isCsrfTokenValid('asupower', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('asupower');
            $power = array_intersect($request->request->get('power'),$this->getUser()->getRoles());
            $user = $this->getDoctrine()->getRepository('UserBaseBundle:User')->find($suser->getUser()->getId());
            $old=array_filter($user->getRoles(),function($a){return !strstr($a,"index_");});
            $role = array_unique(array_merge($old,$power));
            $user->setRoles($role);
            $validator = $this->get('validator');
            $eruser = $validator->validate($user);
            if(count($eruser) == 0)
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', 'suser.act_true');
            }else{
                $this->addFlash('error', 'suser.act_false');
            }
            return $this->redirectToRoute('suserlist',array('web'=>$web,'state'=>2));
        }
        return $this->render('UserSiteBundle:Web/User:power.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'_suserclist')")
     * @Route("/suserlist/{state}/{page}", name="suserlist", defaults={"page"="1"}, requirements={"page": "\d+","state": "(0|1|2){1}"})
     */
    public function suserlist(Request $request,$web,$page,$state)
    {
        $data['users'] = $this->getDoctrine()->getRepository('UserSiteBundle:Siteuser')->page($web,$page,$state);
        $data['text'] = $this->getParameter('conttyp');
        $data['spost'] = $this->getDoctrine()->getRepository('UserSiteBundle:Sitepost')->findBySite($web);
        $data['state'] = $state;
        $data['ti_state'] = 'suser.state.'.$state;
        return $this->render('UserSiteBundle:Web/User:list.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'_sueradd')")
     * @Route("/suserlist/add", name="addsuser")
     */
    public function addsuser(Request $request,$web)
    {
        $data = [];
        $er = 0;
        if($request->isMethod('post')&&$this->isCsrfTokenValid('asuser', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('asuser');
            $cuser = $this->getDoctrine()->getRepository('UserBaseBundle:User')->findOneByUsername($request->request->get('username'));
            if($request->request->get('newuser')=='1')
            {
                if(!empty($cuser)) $er = 1;
                $user = new User();
                $encoder = $this->container->get('security.password_encoder');
                $user->setUsername($request->request->get('username'));
                $user->setPassword($encoder->encodePassword($user,$request->request->get('password')));
                $user->setEmail($request->request->get('email'));
                $user->setRoles(array('ROLE_USER'));
                $user->setState(0);
            }else{
                $user = $cuser;
            }
            $Siteuser = new Siteuser();
            $Siteuser->setSite($web);
            $Siteuser->setPost($request->request->get('post'));
            $Siteuser->setContent($request->request->get('content'));
            $Siteuser->setSort($request->request->get('sort'));
            $Siteuser->setState($request->request->get('state'));
            // $Siteuser->setUid($user->getId());
            $Siteuser->setUser($user);

            $validator = $this->get('validator');
            $eruser = $validator->validate($user);
            $ersuser = $validator->validate($Siteuser);
            if(empty($er)&&count($eruser) == 0 && count($ersuser) == 0)
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->persist($Siteuser);
                $manager->flush();
                $this->addFlash('success', 'suser.act_true');
            }else{
                $this->addFlash('error', 'suser.act_false');
            }
            return $this->redirectToRoute('suserlist',array('web'=>$web,'state'=>2));
        }
        $data['text'] = $this->getParameter('conttyp');
        $data['spost'] = $this->getDoctrine()->getRepository('UserSiteBundle:Sitepost')->findBySite($web);
    	return $this->render('UserSiteBundle:Web/User:add.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'_suserup')")
     * @Route("/editsuser/{id}", name="editsuser", requirements={"id": "\d+"})
     */
    public function editsuser(Request $request,$web,$id)
    {
        $data['suser'] = $Siteuser = $this->getDoctrine()->getRepository('UserSiteBundle:Siteuser')->find($id);
        if(empty($Siteuser))
        {
            $this->addFlash('error', 'suser.no_info');
            return $this->redirectToRoute('suserlist',array('web'=>$web,'state'=>2));
        }

        if($request->isMethod('post')&&$this->isCsrfTokenValid('asuser', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('asuser');
            $user = $this->getDoctrine()->getRepository('UserBaseBundle:User')->find($Siteuser->getUid());
            $Siteuser->setSite($web);
            $Siteuser->setPost($request->request->get('post'));
            $Siteuser->setContent($request->request->get('content'));
            $Siteuser->setSort($request->request->get('sort'));
            $Siteuser->setState($request->request->get('state'));
            $Siteuser->setUser($user);

            $validator = $this->get('validator');
            $ersuser = $validator->validate($Siteuser);
            if(!empty($user) && count($ersuser) == 0)
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($Siteuser);
                $manager->flush();
                $this->addFlash('success', 'suser.act_true');
            }else{
                $this->addFlash('error', 'suser.act_false');
            }
            return $this->redirectToRoute('suserlist',array('web'=>$web,'state'=>2));
        }
        $data['text'] = $this->getParameter('conttyp');
        $data['spost'] = $this->getDoctrine()->getRepository('UserSiteBundle:Sitepost')->findBySite($web);
        return $this->render('UserSiteBundle:Web/User:edit.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'_suserup')")
     * @Route("/usustate/{id}/{bool}", name="usustate", requirements={"id": "\d+","bool": "(t|f){1}"})
     */
    public function upsuserstate(Request $request,$web,$id,$bool)
    {
        if($request->isMethod('post')&&$this->isCsrfTokenValid('ususer', $request->request->get('_token')))
        {
            $state = $bool == 't' ? 2 : 0;
            $Siteuser = $this->getDoctrine()->getRepository('UserSiteBundle:Siteuser')->find($id);
            $Siteuser->setState($state);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($Siteuser);
            $manager->flush();
            $this->addFlash('success', 'suser.act_true');
        }else{
            $this->addFlash('error', 'suser.act_false');
        }
        $this->container->get('security.csrf.token_manager')->removeToken('ususer');
        return $this->redirectToRoute('suserlist',array('web'=>$web,'state'=>2));
    }

    /**
     * @Security("has_role(web~'_suserdel')")
     * @Route("/delsuser/{id}", name="delsuser", requirements={"id": "\d+"})
     */
    public function delsuser(Request $request,$web,$id)
    {
        $suser = $this->getDoctrine()->getRepository('UserSiteBundle:Siteuser')->findOneBy(array('site'=>$web,'id'=>$id));
        if(!empty($suser)&&$request->isMethod('post')&&$this->isCsrfTokenValid('ususer', $request->request->get('_token')))
        {
            $suser->setState(0);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($suser);
            $manager->flush();
            $this->addFlash('success', 'suser.act_true');
        }else{
            $this->addFlash('error', 'suser.delete_error');
        }
        $this->container->get('security.csrf.token_manager')->removeToken('ususer');
        return $this->redirectToRoute('suserlist',array('web'=>$web,'state'=>2));
    }

    /**
     * @Security("has_role(web~'_suserzlist')")
     * @Route("/postlist/{page}", name="postlist", defaults={"page"="1"}, requirements={"page": "\d+"})
     */
    public function postlist(Request $request,$web,$page)
    {
        $data['post'] = $this->getDoctrine()->getRepository('UserSiteBundle:Sitepost')->page($web,$page);
        return $this->render('UserSiteBundle:Web/Post:list.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'_suserzlist')")
     * @Route("/postlist/add", name="addspost")
     */
    public function addspost(Request $request,$web)
    {
        $data = [];
        if($request->isMethod('post')&&$this->isCsrfTokenValid('aspost', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('aspost');
            $spost = new Sitepost();
            $spost->setSite($web);
            $spost->setName($request->request->get('name'));
            $spost->setPid($request->request->get('pid'));
            $spost->setSort($request->request->get('sort'));
            $spost->setState($request->request->get('state'));
            $validator = $this->get('validator');
            $errors = $validator->validate($spost);
            if(count($errors) == 0)
            {
                if(!empty($spost->getPid()))
                {
                    $pinfo = $this->getDoctrine()->getRepository('UserSiteBundle:Sitepost')->find($spost->getPid());
                    if(!empty($pinfo))
                    {
                        $pm = !empty($pinfo->getMakeup()) ? $pinfo->getMakeup().'-'.$pinfo->getId() : $pinfo->getId();
                        $spost->setMakeup($pm);
                        $spost->setCpost($pinfo);
                    }
                }
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($spost);
                $manager->flush();
                return $this->redirectToRoute('postlist',array('web'=>$web));
            }
            $data['state'] = '1';
            $data['content'] = '添加失败!传入数据错误，如有疑问请联系管理员！';
        }
        $data['post'] = $this->getDoctrine()->getRepository('UserSiteBundle:Sitepost')->findAll();
        return $this->render('UserSiteBundle:Web/Post:add.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'_suserzlist')")
     * @Route("/editpost/{id}", name="editpost", requirements={"id": "\d+"})
     */
    public function editpost(Request $request,$web,$id)
    {
        $data = [];
        $spost = $this->getDoctrine()->getRepository('UserSiteBundle:Sitepost')->find($id);
        if($request->isMethod('post')&&$this->isCsrfTokenValid('aspost', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('aspost');
            $spost->setSite($web);
            $spost->setName($request->request->get('name'));
            $pid=!empty($request->request->get('pid'))?intval($request->request->get('pid')):null;
            $spost->setPid($pid);
            $spost->setSort($request->request->get('sort'));
            $spost->setState($request->request->get('state'));
            $validator = $this->get('validator');
            $errors = $validator->validate($spost);
            if(count($errors) == 0)
            {
                if(!empty($spost->getPid()))
                {
                    $pinfo = $this->getDoctrine()->getRepository('UserSiteBundle:Sitepost')->find($spost->getPid());
                    if(!empty($pinfo))
                    {
                        $pm = !empty($pinfo->getMakeup()) ? $pinfo->getMakeup().'-'.$pinfo->getId() : $pinfo->getId();
                        $spost->setMakeup($pm);
                        $spost->setCpost($pinfo);
                    }
                }else{
                    $spost->setMakeup(null);
                    $spost->setCpost(null);
                }
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($spost);
                $manager->flush();
                return $this->redirectToRoute('postlist',array('web'=>$web));
            }
            $data['state'] = '1';
            $data['content'] = '添加失败!传入数据错误，如有疑问请联系管理员！';
        }
        $data['post'] = $this->getDoctrine()->getRepository('UserSiteBundle:Sitepost')->findAll();
        $data['pinfo'] = $spost;
        return $this->render('UserSiteBundle:Web/Post:edit.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'_suserzlist')")
     * @Route("/delpost/{id}", name="delpost", requirements={"id": "\d+"})
     */
    public function delpost(Request $request,$web,$id)
    {
        $post = $this->getDoctrine()->getRepository('UserSiteBundle:Sitepost')->findOneBy(array('site'=>$web,'id'=>$id));
        $cpost = $this->getDoctrine()->getRepository('UserSiteBundle:Sitepost')->findOneBy(array('pid'=>$id));
        if(!empty($post)&&empty($cpost))
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($post);
            $manager->flush();
        }else{
            $this->addFlash('error', 'post.delete_error');
        }
        return $this->redirectToRoute('postlist',array('web'=>$web));
    }
}
