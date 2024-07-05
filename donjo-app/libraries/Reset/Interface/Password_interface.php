<?php



interface Password_interface
{
    /**
     * Constant representing a successfully sent reminder.
     *
     * @var string
     */
    public const RESET_LINK_SENT = 'sent';

    /**
     * Constant representing a successfully sent verify.
     *
     * @var string
     */
    public const VERIFY_LINK_SENT = 'verify';

    /**
     * Constant representing a successfully reset password.
     *
     * @var string
     */
    public const PASSWORD_RESET = 'reset';

    /**
     * Constant representing the user not found response.
     *
     * @var string
     */
    public const INVALID_USER = 'user';

    /**
     * Constant representing an invalid token.
     *
     * @var string
     */
    public const INVALID_TOKEN = 'token';

    /**
     * Constant representing a throttled reset attempt.
     *
     * @var string
     */
    public const RESET_THROTTLED = 'throttled';

    /**
     * Send a password reset link to a user.
     *
     * @return string
     */
    public function sendResetLink(array $credentials, ?Closure $callback = null);

    /**
     * Send a password reset link to a user.
     *
     * @return string
     */
    public function sendVerifyLink(array $credentials, ?Closure $callback = null);

    /**
     * Reset the password for the given token.
     *
     * @return mixed
     */
    public function reset(array $credentials, Closure $callback);

    /**
     * Get the user for the given credentials.
     *
     * @throws UnexpectedValueException
     *
     * @return mixed
     */
    public function getUser(array $credentials);

    /**
     * Create a new password reset token for the given user.
     *
     * @param mixed $user
     *
     * @return string
     */
    public function createToken($user);

    /**
     * Delete password reset tokens of the given user.
     *
     * @param mixed $user
     *
     * @return void
     */
    public function deleteToken($user);

    /**
     * Validate the given password reset token.
     *
     * @param string $token
     * @param mixed  $user
     *
     * @return bool
     */
    public function tokenExists($user, $token);

    /**
     * Get the password reset token repository implementation.
     *
     * @return Password_reset_interface
     */
    public function getRepository();
}
