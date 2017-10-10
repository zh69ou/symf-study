<?php

namespace User\SiteBundle\Repository;
use User\SiteBundle\Entity\Siteuser;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * SiteuserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SiteuserRepository extends \Doctrine\ORM\EntityRepository
{
    public function querysearch($site,$state)
    {
        if($state=='')
        {
            return $this->getEntityManager()
                ->createQuery('
                    SELECT s
                    FROM UserSiteBundle:Siteuser s
                    WHERE s.site = :site
                    ORDER BY s.sort DESC,s.id DESC
                ')->setParameter('site', $site)
            ;
        }else{
            return $this->getEntityManager()
                ->createQuery('
                    SELECT s
                    FROM UserSiteBundle:Siteuser s
                    WHERE s.site = :site AND s.state = :state
                    ORDER BY s.sort DESC,s.id DESC
                ')->setParameter('site', $site)->setParameter('state', $state)
            ;
        }
    }

    public function page($site,$page = 1,$state='')
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->querysearch($site,$state), false));
        $paginator->setMaxPerPage(Siteuser::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

}