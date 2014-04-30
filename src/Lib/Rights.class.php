<?php

final class Rights {

    /**
     * The lowest level of rights
     * Just someone who is surfing on the site
     */
    const USER = 0;

    /**
     * Someone who is on the mailing list but not a member
     */
    const BASIC = 1;

    /**
     * A member of the association
     */
    const MEMBER = 2;

    /**
     * As an administrator, has all the rights
     */
    const ADMIN = 3;
}

?>
