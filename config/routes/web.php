<?php

$router->get('/login', 'UsuarioController@login');
$router->post('/login/authenticate', 'UsuarioController@authenticate');
$router->get('/logout', 'UsuarioController@logout');
