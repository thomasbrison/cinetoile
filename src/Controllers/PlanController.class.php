<?php

require_once 'Controller.class.php';

/**
 * Description of PlanController
 *
 * @author thomas
 */
class PlanController extends Controller  {
    public function defaultAction() {
        $this->render('plan');
    }
}

?>
