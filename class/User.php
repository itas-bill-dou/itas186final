<?php

require_once("Database.php");
require_once("Auth.php");
require_once("ActiveRecord.php");

class User extends Database implements ActiveRecord
{
    private static $dbName = 'marina';

    // Add your fields here that directly match the names of the columns in the user table.
    protected $id;
    protected $username;
    protected $password;
    protected $first_name;
    protected $last_name;
    protected $gender;
    protected $phone;
    protected $user_type = 0;

    /**
     * Call the parent constructor to use a different database
     */
    function __construct()
    {
        parent::__construct(self::$dbName);
    }

    /**
     * Find and return a single resource by its id
     *
     * @param int $id
     * @return ActiveRecord
     */
    public static function find(int $id): ActiveRecord
    {
        // We call getInstance here because this is a static function
        $db = Database::getInstance(self::$dbName);
        return $db->fetch(
            'SELECT * FROM `users` WHERE id = ?;',
            [$id],
            'User'
        );
    }

    /**
     * Find and return all resources
     *
     * @return ActiveRecord[]
     */
    public static function findAll(): array
    {
        // We call getInstance here because this is a static function
        $db = Database::getInstance(self::$dbName);
        return $db->fetchAll(
            'SELECT * FROM `users`;',
            [],
            'User'
        );
    }

    /**
     * Creates a new resource and returns its id
     *
     * @return int
     */
    public function create(): int
    {
        $username = $this->username;
        $password = $this->password;
        $firstName = $this->first_name;
        $lastName = $this->last_name;
        $gender = $this->gender;
        $phone = $this->phone;
        $user_type = $this->user_type;

        // If the username is available
        if (!Auth::getByUsername($username)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            return $this->insert(
                'INSERT INTO `users` (`username`, `password`, `first_name`, `last_name`, `gender` , `phone`, `user_type`)
                VALUES (?, ?, ?, ?, ?, ?, ?);',
                [$username, $hashedPassword, $firstName, $lastName, $gender, $phone, $user_type]
            );
        }
    }

    /**
     * Updates resource after calling its setters
     *
     * @return void
     */
    public function update(): void
    {
        $id = $this->id;
        $username = $this->username;
        $firstName = $this->first_name;
        $lastName = $this->last_name;
        $gender = $this->gender;
        $phone = $this->phone;
        // We don't update password here, handled by another function

        $this->fetch(
            'UPDATE `users`
            SET username = ?,
                first_name = ?,
                last_name = ?,
                gender = ?,
                phone = ?
            WHERE id = ?;',
            [$username, $firstName, $lastName, $gender, $phone, $id]
        );
    }

    /**
     * Deletes resource by its id
     *
     * @return void
     */
    public function delete(): void
    {
        $id = $this->id;
        $this->fetch(
            'DELETE FROM `users` WHERE id = ?;',
            [$id]
        );
    }

    /**
     * Change a user's password in the database given a user id
     *
     * @param int $id The currently logged in user id
     * @param string $oldPassword The current password
     * @param string $newPassword The new password
     *
     * @return boolean true if successful, otherwise false.
     */
    public function changePassword(int $id, string $oldPassword, string $newPassword): bool
    {
        $user = $this->find($id);
        if (password_verify($oldPassword, $user->password)) {
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $this->fetch(
                'UPDATE `users` SET password = ? WHERE id = ?;',
                [$hashedNewPassword, $user->id]
            );
            return true;
        }

        return false;
    }

    // Getters/Setters

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $firstname
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $lastname
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * @param string $user_type
     */
    public function setUserType($user_type)
    {
        $this->user_type = $user_type;
    }

    public function isAdmin()
    {
        return $this->user_type;
    }
}
