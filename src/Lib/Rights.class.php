<?php

class Rights {

    /**
     * The lowest level of rights
     * Just someone who is surfing on the site
     * @var int 0
     */
    static $USER = 0;

    /**
     * Someone who is on the mailing list but not a member
     * @var int 1
     */
    static $BASIC = 1;

    /**
     * A member of the association
     * @var int 2
     */
    static $MEMBER = 2;

    /**
     * As an administrator, has all the rights
     * @var int 3
     */
    static $ADMIN = 3;
}

?>
