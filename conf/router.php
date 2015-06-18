<?php
/**
 * Created by PhpStorm.
 * User: lboykov
 * Date: 15-1-26
 * Time: 22:08
 */

return array(
    'routers' => array(
        'router' => array(
            'artists' => array(
                'artists_index' => array(
                    'controller' => '@BlogModule\Artists',
                    'action' => 'index',
                    'route' => '/artists/{id}',
                    'parameters' => '{id'
                ),
                'artists_view' => array(
                    'controller' => '@BlogModule\Artists',
                    'action' => 'view',
                    'route' => '/artists/view',
                    'parameters' => '{id}'
                )
            )
        )
    )
);