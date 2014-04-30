<?php

/**
 * Description of Routes
 *
 * @author Thomas Brison <thomas.brison@grenoble-inp.org>
 */
final class Routes {
    const index = 'index';
    const plan = 'plan';
    const presentation = 'presentation';
    const admin = 'admin';
    const connection = 'index/connexion';
    const deconnection = 'index/deconnexion';
    const films = 'films';
    const members = 'membres';
    const diffusions = 'diffusions';
    const profile = 'profil';

    /**
     * Get absolute route. Usefull for views.
     * @param string $route
     * @return string
     */
    final static function getRoute($route) {
        return root . '/' . $route;
    }
}
