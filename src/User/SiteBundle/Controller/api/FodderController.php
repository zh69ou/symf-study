<?php

namespace User\SiteBundle\Controller\api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use User\SiteBundle\Entity\Fodder;

/**
 * @Route("/{web}/api/site", defaults={"web"="index"}, requirements={"web":"(?!admin)\w+"})
 */
class FodderController extends Controller
{
    /**
     * @Security("has_role(web~'_fodderlist')")
     * @Route("/fodder/{page}", name="api_fodderlist", defaults={"page"="1"}, requirements={"page": "\d+"})
     */
    public function fodderlist(Request $request,$web,$page)
    {
        $data['fodders'] = $this->getDoctrine()->getRepository('UserSiteBundle:Fodder')->page($page);
        return $this->json($data);
    }

    /**
     * @Security("has_role(web~'_fodderadd')")
     * @Route("/fodder/add", name="api_addfodder")
     */
    public function addfodder(Request $request,$web)
    {
        $data['error'] = '1';
        if($request->isMethod('post')&&$this->isCsrfTokenValid('api_afodder', $request->request->get('_token')))
        {
            // $this->container->get('security.csrf.token_manager')->removeToken('api_afodder');
            $fodder = new Fodder();
            $fodder->setSite($web);
            $fodder->setUid($this->getUser()->getId());
            $fodder->setType($request->request->get('type'));
            $fodder->setTitle($request->request->get('title'));
            $file = $request->files->get('content');
            if(!empty($file))
            {
                $fodder->setContent($file);
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
                    $data['fodder']['id'] = $fodder->getId();
                    $data['fodder']['title'] = $fodder->getTitle();
                    $data['error'] = '0';
                }
            }
        }
        return $this->json($data);
    }

    /**
     * @Security("has_role(web~'_fodderdel')")
     * @Route("/fodder/del/{id}", name="api_delfodder", requirements={"id": "\d+"})
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
        $data['error'] = '0';
        return $this->json($data);
    }
}
