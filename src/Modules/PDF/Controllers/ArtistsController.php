<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-10-1
 * Time: 0:17
 */

namespace Modules\PDF\Controllers;

use Doctrine\ORM\EntityManager;
use Lubakka\Controllers\MasterController;
use Lubakka\View\View;
use Modules\PDF\Entities\Artists\Artists;

class ArtistsController extends MasterController {

    public function indexAction($id){

        //$em = $this->get('doctrine');

        /** @var $e EntityManager */
        //$e = $em->getEm();

        //$artists = $e->getRepository('src\Entities\Artists\Artists')->find($id);
        $artists = new Artists();
        $artists->setName('lyushoPDF');
//
//        $e->persist($artists);
//        $e->flush();

        //return View::layout('@Artists:Artists/index', array('d' => 'test', 'id' => $id, 'artists' => $artists));
        $return = $this->layout('@Artists:Artists/index', array('d' => 'test', 'id' => $id, 'artists' => $artists));
        return $return;
    }
    
    public function viewAction($id) {
        $em = $this->get('doctrine');

        /** @var $e EntityManager */
        $e = $em->getEm();

        $artist = $e->getRepository('src\Entities\Artists\Artists')->find($id);

        return $this->layout('@Artists:Artists/index', array('d' => 'test', 'id' => $id, 'artists' => $artist));
    }
} 