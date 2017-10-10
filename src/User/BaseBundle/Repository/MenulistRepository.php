<?php

namespace User\BaseBundle\Repository;
use User\BaseBundle\Entity\Menulist;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * MenulistRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MenulistRepository extends \Doctrine\ORM\EntityRepository
{
	public function querysearch($state)
	{
		if($state=='')
		{
			return $this->getEntityManager()
	            ->createQuery('
	                SELECT m
	                FROM UserBaseBundle:Menulist m
	                ORDER BY m.id DESC
	            ');
		}else{
			return $this->getEntityManager()
	            ->createQuery('
	                SELECT m
	                FROM UserBaseBundle:Menulist m
	                WHERE m.state = :state
	                ORDER BY m.id DESC
	            ')->setParameter('state', $state)
	        ;
		}
	}

	public function page($page = 1,$state='')
	{
		$paginator = new Pagerfanta(new DoctrineORMAdapter($this->querysearch($state), false));
        $paginator->setMaxPerPage(Menulist::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
	}

}
