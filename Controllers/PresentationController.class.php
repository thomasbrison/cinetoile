<?php

require_once 'Controller.class.php';

/**
 * Description of EquipeController
 *
 * @author thomas
 */
class PresentationController extends Controller  {
    public function defaultAction() {
        $this->render('presentation');
    }
}

?>
