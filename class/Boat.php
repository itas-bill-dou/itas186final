<?php

require_once("ActiveRecord.php");
require_once("Database.php");

class Boat extends Database implements ActiveRecord
{
    private static $dbName = 'marina';

    // These fields directly match the names of the columns in the Boat table.
    protected $id;
    protected $name;
    protected $reg_num;
    protected $length;
    protected $image;
    protected $user_id;

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
            'SELECT * FROM `boats` WHERE id = ?;',
            [$id],
            'Boat'
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
            'SELECT * FROM `boats`;',
            'Boat'
        );
    }

    /**
     * Creates a new resource and returns its id
     *
     * @return int
     */
    public function create(): int
    {
        $name = $this->name;
        $reg_num = $this->reg_num;
        $length = $this->length;
        $image = $this->image;
        $user_id = $this->user_id;

        return $this->insert(
            "INSERT INTO boat (name, reg_num, length, image, user_id)
            VALUES (?, ?, ?, ?, ?);",
            [$name, $reg_num, $length, $image, $user_id]
        );
    }

    /**
     * Updates a resource after calling its setters
     *
     * @return void
     */
    public function update(): void
    {
        $id = $this->id;
        $name = $this->name;
        $reg_num = $this->reg_num;
        $length = $this->length;
        $image = $this->image;
        $user_id = $this->user_id;

        $this->fetch(
            'UPDATE `boats`
            SET name = ?,
                reg_num = ?,
                length = ?,
                image = ?,
                user_id = ?
            WHERE id = ?;',
            [$name, $reg_num, $length, $image, $user_id, $id]
        );
    }

    /**
     * Deletes a boat by its id
     *
     * @return void
     */
    public function delete(): void
    {
        $id = $this->id;
        $this->fetch(
            'DELETE FROM `boats` WHERE id = ?;',
            [$id]
        );
    }

    /**
     * Find and return all resources/boats belongs to given user_id
     *
     * @return ActiveRecord[]
     */
    public static function findBoatsByUserId($user_id)
    {
        // We call getInstance here because this is a static function
        $db = Database::getInstance(self::$dbName);
        return $db->fetchAll(
            'SELECT * FROM `boats` WHERE user_id = ?;',
            [$user_id],
            'Boat'
        );
    }

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getRegNumber()
    {
        return $this->reg_num;
    }

    /**
     * @param int $reg_num
     */
    public function setRegNumber($reg_num)
    {
        $this->reg_num = $reg_num;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
}
