<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-10-1
 * Time: 0:17
 */

namespace src\Controllers;

use Kernel\Controllers\Master_Controller;
use Kernel\Doctrine\EntityManager;
use src\Entities\Artists;

class Artists_Controller extends Master_Controller {

    public function indexAction($id){
        $em = EntityManager::getEntityManager();
        $e = $em->getEm();


        $artists = new Artists\Artists();
        $artists->setName('lyusho');

        $e->persist($artists);
        $e->flush();

        echo "Created Artists with ID " . $artists->getId() . "\n";
        return $this->layout('@Artists:Artists/index', array('d' => 'test', 'id' => $id));
    }
    
    public function viewAction($id) {
        return $this->render('@Artists:Artists/view', array('d' => $id, 'requests' => 'да става', 'ses' => $this->getSession()));
    }
} 