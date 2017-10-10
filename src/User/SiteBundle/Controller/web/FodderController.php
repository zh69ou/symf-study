<?php

namespace User\SiteBundle\Controller\web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use User\SiteBundle\Entity\Fodder;

/**
 * @Route("/{web}/site", defaults={"web"="index"}, requirements={"web":"(?!admin)\w+"})
 */
class FodderController extends Controller
{
    /**
     * @Security("has_role(web~'_fodderlist')")
     * @Route("/fodder/{page}", name="fodderlist", defaults={"page"="1"}, requirements={"page": "\d+"})
     */
    public function fodderlist(Request $request,$web,$page)
    {
        $data['fodders'] = $this->getDoctrine()->getRepository('UserSiteBundle:Fodder')->page($page);
        return $this->render('UserSiteBundle:Web/Fodder:list.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'_fodderadd')")
     * @Route("/fodder/add", name="addfodder")
     */
    public function addfodder(Request $request,$web)
    {
        $error = [];
        if($request->isMethod('post')&&$this->isCsrfTokenValid('afodder', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('afodder');
            $fodder = new Fodder();
            $fodder->setSite($web);
            $fodder->setUid($this->getUser()->getId());
            $fodder->setType($request->request->get('type'));
            $fodder->setTitle($request->request->get('title'));
            $file = $request->files->get('fname');
            if(!empty($file))
            {
                // $fodder->setContent($file->guessExtension());
                $fodder->setSize($file->getSize());
                $fodder->setShare($request->request->get('share',0));
                $fodder->setState($request->request->get('state',0));
                $validator = $this->get('validator');
                $errors = $validator->validate($fodder);
                if(count($errors) == 0)
                {
                    $filename = md5(uniqid()).'.'.$file->guessExtension();
                    $url = 'uploads/'.$web.'/';
                    $dir = $this->container->getParameter('kernel.root_dir').'/../web/'.$url;
                    $file->move($dir,$filename);
                    $fodder->setContent($url.$filename);
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($fodder);
                    $manager->flush();
                    return $this->redirectToRoute('fodderlist',array('web'=>$web));
                }
            }
            $error['state'] = '1';
            $error['content'] = '添加失败!传入数据错误，如有疑问请联系管理员！';
        }
        return $this->render('UserSiteBundle:Web/Fodder:add.html.twig',$error);
    }

    /**
     * @Security("has_role(web~'_fodderdel')")
     * @Route("/fodder/del/{id}", name="delfodder", requirements={"id": "\d+"})
     */
    public function delfodder(Request $request,$web,$id)
    {
        $fodder = $this->getDoctrine()->getRepository('UserSiteBundle:Fodder')->findOneBy(array('site'=>$web,'id'=>$id));
        if(!empty($fodder)&&!empty($fodder->getContent()))
        {
            @unlink($this->container->getParameter('kernel.root_dir').'/../web/'.$fodder->getContent());
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($fodder);
            $manager->flush();
        }
        return $this->redirectToRoute('fodderlist',array('web'=>$web));
    }
}
