<?php

namespace User\SiteBundle\Repository;
use User\SiteBundle\Entity\Site;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * SiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SiteRepository extends \Doctrine\ORM\EntityRepository
{
	public function querysearch()
	{
		return $this->getEntityManager()
            ->createQuery('
                SELECT s
                FROM UserSiteBundle:Site s
                ORDER BY s.id DESC
            ')
        ;
	}

	public function page($page = 1)
	{
		$paginator = new Pagerfanta(new DoctrineORMAdapter($this->querysearch(), false));
        $paginator->setMaxPerPage(Site::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
	}

}
