<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends EntityRepository
{
  public function findByCategories($categories)
  {
    $dql = 'SELECT p FROM Club\ShopBundle\Entity\Product p JOIN p.categories c WHERE c.id IN ('.join(",", $categories).')';

    return $this->_em->createQuery($dql)->getResult();
  }
}
