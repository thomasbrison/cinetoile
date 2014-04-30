<?php

/**
 * Description of Routes
 *
 * @author Thomas Brison <thomas.brison@grenoble-inp.org>
 */
final class Routes {
    const index = 'index';
    const map = 'plan';
    const presentation = 'presentation';
    const admin = 'admin';
    const connection = 'connexion';
    const deconnection = 'deconnexion';
    const films = 'films';
    const filmsCreate = 'films/ajouter';
    const filmsUpdate = 'films/modifier';
    const filmsDelete = 'films/supprimer';
    const members = 'membres';
    const membersCreate = 'membres/ajouter';
    const membersUpdate = 'membres/modifier';
    const membersDelete = 'membres/supprimer';
    const membersUpdateRights = 'membres/modifierDroits';
    const diffusions = 'diffusions';
    const diffusionsCreate = 'diffusions/ajouter';
    const diffusionsUpdate = 'diffusions/modifier';
    const diffusionsDelete = 'diffusions/supprimer';
    const profile = 'profil';
    const profileUpdate = 'profil/modifier';
    const profileDelete = 'profil/supprimer';
    const vote = '';

    /**
     * Get absolute route. Usefull for views.
     * @param string $route
     * @return string
     */
    final static function getRoute($route) {
        return root . '/' . $route;
    }
}
