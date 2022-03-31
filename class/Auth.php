<?php

require_once('Database.php');
require_once('Exception.php');

class Auth extends Database
{
    private static $dbName = 'marina';

    /**
     * Attempt to log the user into the system with the supplied username and
     * password. If successful, the method should set the users logged in status.
     *
     * @param string $username username of the user to be logged in
     * @param string $password unencrypted password
     *
     * @return boolean true if the username and password matched a record in the database, else false
     */
    public static function login($username, $password): bool
    {
        // Sanitize user input
        $sanitizedUsername = filter_var($username, FILTER_SANITIZE_EMAIL);

        try {
            // Lookup the user with the values we now have
            // Note: We call getInstance here because we're in a static function and can't use $this
            $user = Database::getInstance(self::$dbName)->fetch(
                'SELECT * FROM `users` WHERE username = ?;',
                [$sanitizedUsername]
            );

            if (!$user) {
                throw new UserNotFoundException();
            }
        } catch (UserNotFoundException $e) {
            // User doesn't exist, bail out
            return false;
        }

        // Validate the password entered matches the hashed password stored on the user
        if (password_verify($password, $user->password)) {
            // If we have the user object, lets put some information into the session
            $_SESSION['userId'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['isLoggedIn'] = true;
            return true;
        }

        return false;
    }

    /**
     * Log the current user out of the system.
     */
    public static function logout()
    {
        unset($_SESSION['userId']);
        unset($_SESSION['username']);
        unset($_SESSION['isLoggedIn']);
        session_destroy();
    }

    /**
     * Get a resource by username
     *
     * @param string $username
     *
     * @return User object || false
     */
    public static function getByUsername(string $username)
    {
        // Note: We call getInstance here because we're in a static function and can't use $this
        $user = Database::getInstance(self::$dbName)->fetch(
            'SELECT * FROM `users` WHERE username = ?;',
            [$username],
        );

        if (!$user) return false;

        // We don't want the password to be returned
        unset($user->password);

        return $user;
    }
}
