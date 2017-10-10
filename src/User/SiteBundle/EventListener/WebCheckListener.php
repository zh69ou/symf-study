<?php
namespace User\SiteBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\Common\Persistence\ObjectManager;

class WebCheckListener
{

    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator,ObjectManager $entityManager)
    {
        $this->urlGenerator = $urlGenerator;
        $this->entityManager = $entityManager;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $web = htmlspecialchars($request->get('web'));

        if ($web=='admin' ||$web=='help' || empty($web) || '/' == $request->getPathInfo()) {
            return;
        }

        $site = $this->entityManager
            ->getRepository('UserSiteBundle:Site');
        $rt = $site->findOneBy(array('name'=>$web,'state'=>'1'));


        if (empty($rt))
        {
            $response = new RedirectResponse($this->urlGenerator->generate('index'));
            $event->setResponse($response);
        }else{
            $request->getSession()->set('webinfo',$rt);
        }
    }
}
