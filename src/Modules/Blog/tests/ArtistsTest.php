<?php
/**
 * Created by PhpStorm.
 * User: lubakka
 * Date: 01.09.15
 * Time: 15:59
 */

namespace Modules\Blog\tests;

use Entities\Artists\Artists;
use PHPUnit_Framework_TestCase;

require_once __DIR__ . '/../../../Entities/Artists/Artists.php';

class ArtistsTest extends PHPUnit_Framework_TestCase
{

    public function testCanBeNegated()
    {
        $a = new Artists();

        $a->setName('da');

        // Assert
        $this->assertEquals('da', $a->getName());
    }

}