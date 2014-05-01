<?php

/**
 * Description of ErrorController
 *
 * @author thomas
 */
class ErrorController extends Controller {

    static $instance;

    public function defaultAction() {
        self::internalServerError();
    }

    private static function getInstance() {
        if (!self::$instance) {
            self::$instance = new ErrorController();
        }
        return self::$instance;
    }

    /**
     * Call the right error method
     * @param int $status
     */
    public static function error($status) {
        switch ($status) {
            case 404:
                $headerMsg = "Not Found";
                break;
            case 500:
                $headerMsg = "Internal Server Error";
                break;
            default:
                self::error(500);
                return;
        }
        self::templateError($status, $headerMsg);
    }

    private static function templateError($status, $headerMsg) {
        header($_SERVER["SERVER_PROTOCOL"] . " $status $headerMsg");
        self::getInstance()->render("Errors/$status");
        exit();
    }

}

?>
