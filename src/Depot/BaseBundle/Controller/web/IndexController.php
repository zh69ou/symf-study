<?php

namespace Depot\BaseBundle\Controller\web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Depot\BaseBundle\Entity\Depottype;
use Depot\BaseBundle\Entity\Depotstate;
use Depot\BaseBundle\Entity\Depot;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/{web}/depot", defaults={"web"="index"}, requirements={"web":"(?!admin|help)\w+"})
 */
class IndexController extends Controller
{
    /**
     * @Security("has_role(web~'depotindex')")
     * @Route("/", name="depotindex")
     */
    public function index(Request $request,$web)
    {
        $data['depot'] = $this->getDoctrine()->getRepository('DepotBaseBundle:Depotstate')->gstatis($this->get('database_connection'),$web);
        $data['depotdata'] = $this->getDoctrine()->getRepository('DepotBaseBundle:Depotstate')->gdepotdata($this->get('database_connection'),$web);
        return $this->render('DepotBaseBundle:Web:index.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'depotlist')")
     * @Route("/list/{page}", name="depotlist", defaults={"page"="1"}, requirements={"page": "\d+"})
     */
    public function depotlist(Request $request,$web,$page)
    {
        $data['depot'] = $this->getDoctrine()->getRepository('DepotBaseBundle:Depot')->page($web,$page);
        $data['depottype'] = $this->getDoctrine()->getRepository('DepotBaseBundle:Depottype')->findBy(array('site'=>$web));
        return $this->render('DepotBaseBundle:Web:list.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'depotiadd')")
     * @Route("/addi", name="depotiadd")
     */
    public function addi(Request $request,$web)
    {
        if($request->isMethod('post')&&$this->isCsrfTokenValid('adddepoticsrf', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('adddepoticsrf');
            $depot = $this->getDoctrine()->getRepository('DepotBaseBundle:Depot')->findOneBy(array('site'=>$web,'codenum'=>$request->request->get('codenum')));
            if(empty($depot))
            {
                $depot = new Depot();
                $depot->setSite($web);
                $depot->setName($request->request->get('name'));
                $depot->setCodenum($request->request->get('codenum'));
                $depot->setStock($request->request->get('stock'));
                $depot->setFodder($request->request->get('fodder'));
                $depot->setType($request->request->get('type'));
                $depot->setSort($request->request->get('sort'));
                $depot->setState($request->request->get('state'));
            }else{
                $this->addFlash('error', 'olddepot');
                return $this->redirectToRoute('depotiadd',array('web'=>$web));
            }
            $depot->setGtime();
            $validator = $this->get('validator');
            $depoterrors = $validator->validate($depot);
            if(count($depoterrors) == 0)
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($depot);
                $manager->flush();
                $this->addFlash('success', 'addsuccess');
            }else{
                $this->addFlash('error', 'adderror');
            }
            return $this->redirectToRoute('depotiadd',array('web'=>$web));
        }
        $data['type'] = $this->getDoctrine()->getRepository('DepotBaseBundle:Depottype')->findBy(array('site'=>$web,'state'=>1),array('sort'=>'desc','id'=>'desc'));
        $data['fodders'] = $this->getDoctrine()->getRepository('UserSiteBundle:Fodder')->findBy(array('site'=>$web,'state'=>1),array('id'=>'desc'));
        return $this->render('DepotBaseBundle:Web:addi.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'depotadd')")
     * @Route("/add", name="depotadd")
     */
    public function add(Request $request,$web)
    {
        if($request->isMethod('post')&&$this->isCsrfTokenValid('adddepotcsrf', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('adddepotcsrf');
            $depot = $this->getDoctrine()->getRepository('DepotBaseBundle:Depot')->findOneBy(array('site'=>$web,'codenum'=>$request->request->get('codenum')));
            if($request->request->get('newdepot')=='1'&&empty($depot))
            {
                $depot = new Depot();
                $depot->setSite($web);
                $depot->setName($request->request->get('name'));
                $depot->setCodenum($request->request->get('codenum'));
                $depot->setStock($request->request->get('num'));
                $depot->setFodder($request->request->get('fodder'));
                $depot->setType($request->request->get('type'));
                $depot->setSort($request->request->get('sort'));
                $depot->setState($request->request->get('state'));
            }elseif(!empty($depot)){
                $depot->setStock($depot->getStock()+$request->request->get('num'));
            }else{
                $this->addFlash('error', 'nodepot');
                return $this->redirectToRoute('depotadd',array('web'=>$web));
            }
            $depot->setGtime();
            $state = new Depotstate();
            $state->setDeid($depot->getId());
            $state->setBaseprice($request->request->get('baseprice'));
            $state->setSellprice($request->request->get('sellprice'));
            $state->setItime();
            $state->setBackups($request->request->get('backups'));
            $state->setNum($request->request->get('num'));
            $state->setState(1);
            $state->setDepot($depot);
            $validator = $this->get('validator');
            $depoterrors = $validator->validate($depot);
            $errors = $validator->validate($state);
            if(count($errors) == 0&&count($depoterrors) == 0)
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($depot);
                $manager->persist($state);
                $manager->flush();
                $this->addFlash('success', 'addsuccess');
            }else{
                $this->addFlash('error', 'adderror');
            }
            return $this->redirectToRoute('depotadd',array('web'=>$web));
        }
        $data['type'] = $this->getDoctrine()->getRepository('DepotBaseBundle:Depottype')->findBy(array('site'=>$web,'state'=>1),array('sort'=>'desc','id'=>'desc'));
        $data['fodders'] = $this->getDoctrine()->getRepository('UserSiteBundle:Fodder')->findBy(array('site'=>$web,'state'=>1),array('id'=>'desc'));
        return $this->render('DepotBaseBundle:Web:add.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'depotaddlist')")
     * @Route("/addlist/{page}", name="depotaddlist", defaults={"page"="1"}, requirements={"page": "\d+"})
     */
    public function addlist(Request $request,$web,$page)
    {
        $data['depotstate'] = $this->getDoctrine()->getRepository('DepotBaseBundle:Depotstate')->page($web,1,$page);
        return $this->render('DepotBaseBundle:Web:inlist.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'depotout')")
     * @Route("/out", name="depotout")
     */
    public function out(Request $request,$web)
    {
        if($request->isMethod('post')&&$this->isCsrfTokenValid('outdepotcsrf', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('outdepotcsrf');
            $depot = $this->getDoctrine()->getRepository('DepotBaseBundle:Depot')->findOneBy(array('codenum'=>$request->request->get('codenum')));
            if(empty($depot))
            {
                $this->addFlash('error', 'nodepot');
                return $this->redirectToRoute('depotout',array('web'=>$web));
            }
            if(empty($depot->getStock())||$depot->getStock()<$request->request->get('num'))
            {
                $this->addFlash('error', 'lackdepot');
                return $this->redirectToRoute('depotout',array('web'=>$web));
            }
            $depot->setStock($depot->getStock()-$request->request->get('num'));
            $depot->setGtime();
            $state = new Depotstate();
            $state->setDeid($depot->getId());
            $state->setBaseprice($request->request->get('baseprice'));
            $state->setSellprice($request->request->get('sellprice'));
            $state->setItime();
            $state->setBackups($request->request->get('backups'));
            $state->setNum($request->request->get('num'));
            $state->setState(2);
            $state->setDepot($depot);
            $validator = $this->get('validator');
            $depoterrors = $validator->validate($depot);
            $errors = $validator->validate($state);
            if(count($errors) == 0&&count($depoterrors) == 0)
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($depot);
                $manager->persist($state);
                $manager->flush();
                $this->addFlash('success', 'addsuccess');
            }else{
                $this->addFlash('error', 'adderror');
            }
            return $this->redirectToRoute('depotout',array('web'=>$web));
        }
        $data['depot'] = $this->getDoctrine()->getRepository('DepotBaseBundle:Depot')->findBy(array('site'=>$web));
        return $this->render('DepotBaseBundle:Web:out.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'depotoutlist')")
     * @Route("/outlist/{page}", name="depotoutlist", defaults={"page"="1"}, requirements={"page": "\d+"})
     */
    public function outlist(Request $request,$web,$page)
    {
        $data['depotstate'] = $this->getDoctrine()->getRepository('DepotBaseBundle:Depotstate')->page($web,2,$page);
        return $this->render('DepotBaseBundle:Web:outlist.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'depotdel')")
     * @Route("/del", name="depotdel")
     */
    public function del(Request $request,$web)
    {

        if($request->isMethod('post')&&$this->isCsrfTokenValid('deldepotcsrf', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('deldepotcsrf');
            $depot = $this->getDoctrine()->getRepository('DepotBaseBundle:Depot')->findOneBy(array('codenum'=>$request->request->get('codenum')));
            if(empty($depot))
            {
                $this->addFlash('error', 'nodepot');
                return $this->redirectToRoute('depotout',array('web'=>$web));
            }
            if(empty($depot->getStock())||$depot->getStock()<$request->request->get('num'))
            {
                $this->addFlash('error', 'lackdepot');
                return $this->redirectToRoute('depotout',array('web'=>$web));
            }
            $depot->setStock($depot->getStock()-$request->request->get('num'));
            $depot->setGtime();
            $state = new Depotstate();
            $state->setDeid($depot->getId());
            $state->setBaseprice($request->request->get('baseprice'));
            $state->setSellprice($request->request->get('sellprice'));
            $state->setItime();
            $state->setBackups($request->request->get('backups'));
            $state->setNum($request->request->get('num'));
            $state->setState(0);
            $state->setDepot($depot);
            $validator = $this->get('validator');
            $depoterrors = $validator->validate($depot);
            $errors = $validator->validate($state);
            if(count($errors) == 0&&count($depoterrors) == 0)
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($depot);
                $manager->persist($state);
                $manager->flush();
                $this->addFlash('success', 'addsuccess');
            }else{
                $this->addFlash('error', 'adderror');
            }
            return $this->redirectToRoute('depotout',array('web'=>$web));
        }
        $data['depot'] = $this->getDoctrine()->getRepository('DepotBaseBundle:Depot')->findBy(array('site'=>$web));
        return $this->render('DepotBaseBundle:Web:del.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'depotdellist')")
     * @Route("/dellist/{page}", name="depotdellist", defaults={"page"="1"}, requirements={"page": "\d+"})
     */
    public function dellist(Request $request,$web,$page)
    {
        $data['depotstate'] = $this->getDoctrine()->getRepository('DepotBaseBundle:Depotstate')->page($web,0,$page);
        return $this->render('DepotBaseBundle:Web:dellist.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'depottype')")
     * @Route("/type/{page}", name="depottype", defaults={"page"="1"}, requirements={"page": "\d+"})
     */
    public function type($web,$page)
    {
        $data['depottype'] = $this->getDoctrine()->getRepository('DepotBaseBundle:Depottype')->page($web,$page);
        return $this->render('DepotBaseBundle:Web:typelist.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'depottypeadd')")
     * @Route("/type/add", name="depottypeadd")
     */
    public function typeadd(Request $request,$web)
    {
        if($request->isMethod('post')&&$this->isCsrfTokenValid('asdepottype', $request->request->get('_token')))
        {
            $this->container->get('security.csrf.token_manager')->removeToken('asdepottype');
            $type = new Depottype();
            $type->setSite($web);
            $type->setName($request->request->get('name'));
            $type->setPid($request->request->get('pid'));
            $type->setSort($request->request->get('sort'));
            $type->setState($request->request->get('state'));
            $type->setDword($request->request->get('dword'));
            $validator = $this->get('validator');
            $errors = $validator->validate($type);
            if(count($errors) == 0)
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($type);
                $manager->flush();
                $this->addFlash('success', 'addsuccess');
            }else{
                $this->addFlash('error', 'adderror');
            }
            return $this->redirectToRoute('depottype',array('web'=>$web));
        }
        $data['depottype'] = $this->getDoctrine()->getRepository('DepotBaseBundle:Depottype')->findBySite($web);
        return $this->render('DepotBaseBundle:Web:typeadd.html.twig',$data);
    }

    /**
     * @Security("has_role(web~'depottypedel')")
     * @Route("/type/del/{id}", name="depottypedel", requirements={"id": "\d+"})
     */
    public function depottypedel(Request $request,$web,$id)
    {
        $type = $this->getDoctrine()->getRepository('DepotBaseBundle:Depottype')->findOneBy(array('site'=>$web,'id'=>$id));
        if(!empty($type))
        {
            $type->setState(0);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($type);
            $manager->flush();
            $this->addFlash('success', 'delsuccess');
        }else{
            $this->addFlash('error', 'delerror');
        }
        return $this->redirectToRoute('depottype',array('web'=>$web));
    }

    /**
     * @Security("has_role(web~'depottypestate')")
     * @Route("/typestate/{id}", name="depottypestate", requirements={"id": "\d+"})
     */
    public function depottypestate(Request $request,$web,$id)
    {
        $type = $this->getDoctrine()->getRepository('DepotBaseBundle:Depottype')->findOneBy(array('site'=>$web,'id'=>$id));
        if(!empty($type))
        {
            $type->setState(1);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($type);
            $manager->flush();
            $this->addFlash('success', 'baksuccess');
        }else{
            $this->addFlash('error', 'bakerror');
        }
        return $this->redirectToRoute('depottype',array('web'=>$web));
    }

    /**
     * @Security("has_role(web~'depotsql')")
     * @Route("/sql", name="depotsql")
     */
    public function sql()
    {
        return $this->render('DepotBaseBundle:Web:sets.html.twig');
    }

    /**
     * @Security("has_role(web~'depotset')")
     * @Route("/set", name="depotset")
     */
    public function set()
    {
        return $this->render('DepotBaseBundle:Web:sets.html.twig');
    }

}
