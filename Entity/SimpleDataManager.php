<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mojo\Sonata\UIBundle\Entity;

use Sonata\CoreBundle\Model\BaseEntityManager;

/**
 * Description of ConfigManager
 *
 * @author jmpantoja
 */
class SimpleDataManager extends BaseEntityManager implements SimpleDataManagerInterface {

    public function findByKey($key) {
        $this->setSubmitted(false);
        /**
         * @var QueryBuilder query
         */
        $query = $this->getRepository()
                ->createQueryBuilder('c')
                ->where('c.key = ?key')
                ->setParameter('key', $key)
                ->setMaxResults(1)
                ->getQuery();


        $promos = array();
        foreach ($query->execute() as $data) {
            $promos[] = array(
                'data' => $data,
                'form' => $this->createForm()->createView(),
            );
        }

        return $promos;
    }

}
