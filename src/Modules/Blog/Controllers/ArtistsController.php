<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-10-1
 * Time: 0:17
 */

namespace Modules\Blog\Controllers;

use Doctrine\ORM\EntityManager;
use Lubakka\Controllers\MasterController;
use Lubakka\View\View;
use Entities\Artists\Artists;

/**
 * Class ArtistsController
 * @package Modules\Blog\Controllers
 */
class ArtistsController extends MasterController {

    /**
     * @param $id
     *
     * @throws \Exception
     */
    public function indexAction($id){

        //$em = $this->get('doctrine');

        /** @var $e EntityManager */
        //$e = $em->getEm();

        //$artists = $e->getRepository('src\Entities\Artists\Artists')->find($id);
        $artists = new Artists();
        $artists->setName('lyusho');
//
//        $e->persist($artists);
//        $e->flush();

        //return View::layout('@Artists:Artists/index', array('d' => 'test', 'id' => $id, 'artists' => $artists));
        $return = $this->render('@Artists:Artists/index', array('d' => 'test', 'id' => $id, 'artists' => $artists));
        return $return;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function viewAction($id) {
        $em = $this->get('doctrine');

        /** @var $e EntityManager */
        $e = $em->getEm();

        $artist = $e->getRepository('Entities\Artists\Artists')->find($id);

        var_dump($artist);exit;

        return $this->render('@Artists:Artists/index', array('d' => 'test', 'id' => $id, 'artists' => $artist));
    }
} 