<?php

/**
 * Description of DeconnexionController
 *
 * @author Thomas Brison <thomas.brison@grenoble-inp.org>
 */
class DeconnexionController extends Controller {

    public function defaultAction() {
        session_destroy();
        header('Location: ' . Routes::getRoute(Routes::connection));
    }

}
