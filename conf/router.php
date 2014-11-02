<?php

return array(
    'routers' => array(
        'router' => array(
            'master' => array(
                'master_index' => array(
                    'controller' => 'Master',
                    'action' => 'index',
                    'route' => '/'
                ),
            ),
            'artis' => array(
                'artists_index' => array(
                    'controller' => 'Artists',
                    'action' => 'index',
                    'route' => '/artists'
                ),
                'artists_view' => array(
                    'controller' => 'Artists',
                    'action' => 'view',
                    'route' => '/artists/view'
                )
            )
        )
    )
);

