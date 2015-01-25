<?php

return array(
    'routers' => array(
        'router' => array(
            'artists' => array(
                'artists_index' => array(
                    'controller' => 'Artists',
                    'action' => 'index',
                    'route' => '/artists/{id}',
                    'parameters' => '{id'
                ),
                'artists_view' => array(
                    'controller' => 'Artists',
                    'action' => 'view',
                    'route' => '/artists/view',
                    'parameters' => '{id}'
                )
            )
        )
    )
);

