<?php



require_once 'donjo-app/libraries/OTP/Abstract_manager.php';
require_once 'donjo-app/libraries/Reset/Email/Email_repository.php';
require_once 'donjo-app/libraries/Reset/Password_repository.php';

class Password extends Abstract_manager
{
    /**
     * {@inheritDoc}
     */
    public function getDefaultDriver()
    {
        return 'email';
    }

    public function createEmailDriver()
    {
        return new Email_repository(new Password_repository());
    }
}
