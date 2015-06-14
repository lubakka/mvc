<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-10-1
 * Time: 0:17
 */

namespace src\Controllers;

use Doctrine\ORM\EntityManager;
use Lubakka\Controllers\MasterController;
use src\Entities\Artists\Artists;

class ArtistsController extends MasterController {

    public function indexAction($id){

        $em = $this->get('doctrine');

        /** @var $e EntityManager */
        $e = $em->getEm();

        $artists = $e->getRepository('src\Entities\Artists\Artists')->find($id);
//        $artists = new Artists();
//        $artists->setName('lyusho');
//
//        $e->persist($artists);
//        $e->flush();

        //echo "Created Artists with ID " . $artists->getId() . "\n";
        return $this->layout('@Artists:Artists/index', array('d' => 'test', 'id' => $id, 'artists' => $artists));
    }
    
    public function viewAction($id) {
        $em = $this->get('doctrine');

        /** @var $e EntityManager */
        $e = $em->getEm();

        $artist = $e->getRepository('src\Entities\Artists\Artists')->find($id);

        return $this->render('@Artists:Artists/view', array('artist' => $artist));
    }
} 