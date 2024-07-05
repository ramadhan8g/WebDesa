<?php



interface Password_reset_interface
{
    /**
     * Create a new token.
     *
     * @param mixed $user
     *
     * @return string
     */
    public function create($user);

    /**
     * Create a new token for the user.
     *
     * @return string
     */
    public function createNewToken();

    /**
     * Determine if a token record exists and is valid.
     *
     * @param mixed  $user
     * @param string $token
     *
     * @return bool
     */
    public function exists($user, $token);

    /**
     * Determine if the given user recently created a password reset token.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function recentlyCreatedToken($user);

    /**
     * Destroy a token record.
     *
     * @param mixed $user
     *
     * @return void
     */
    public function destroy($user);

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function destroyExpired();
}
