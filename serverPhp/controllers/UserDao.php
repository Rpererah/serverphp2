<?php

class UserDAO {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function create(User $user) {
        $name = $user->getName();
        $email = $user->getEmail();
        $password = $user->getPassword();

        $sql = "INSERT INTO user (name, email, password) VALUES (?, ?, ?)";

        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute([$name, $email, $password]);

            return true;
        } catch (PDOException $e) {
            die('Query failed: ' . $e->getMessage());
        }
    }

    public function update(User $user) {
        $id = $user->getId();
        $name = $user->getName();
        $email = $user->getEmail();
        $password = $user->getPassword();

        $sql = "UPDATE user SET name = ?, email = ?, password = ? WHERE id = ?";

        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute([$name, $email, $password, $id]);

            return true;
        } catch (PDOException $e) {
            die('Query failed: ' . $e->getMessage());
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM user WHERE id = ?";

        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute([$id]);

            return true;
        } catch (PDOException $e) {
            die('Query failed: ' . $e->getMessage());
        }
    }

    public function getById($id) {
        $sql = "SELECT * FROM user WHERE id = ?";

        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return new User($row['id'], $row['name'], $row['email'], $row['password']);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            die('Query failed: ' . $e->getMessage());
        }
    }

    public function getAll() {
        $sql = "SELECT * FROM user";

        try {
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $users = [];

            foreach ($rows as $row) {
                $users[] = new User($row['id'], $row['name'], $row['email'], $row['password']);
            }

            return $users;
        } catch (PDOException $e) {
            die('Query failed: ' . $e->getMessage());
        }
    }
}
?>