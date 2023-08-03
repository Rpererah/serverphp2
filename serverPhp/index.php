<?php
require_once 'models/Database.php';
require_once 'models/User.php';
require_once 'controllers/UserDao.php';

$db = new Database('localhost', 8888, 'teste', 'root', 'root');
$db->connect();

$userDAO = new UserDAO($db);

$requestMethod = $_SERVER['REQUEST_METHOD'];
$route = $_GET['route'] ?? '';

switch ($requestMethod) {
    case 'GET':
        if ($route === 'users') {
            $users = $userDAO->getAll();
            if ($users) {
                echo json_encode($users);
            } else {
                echo 'No users found';
            }
        } elseif (strpos($route, 'users/') === 0) {
            $userId = intval(substr($route, strlen('users/')));
            $user = $userDAO->getById($userId);
            if ($user) {
                echo json_encode($user);
            } else {
                echo 'User not found';
            }
        } else {
            echo 'Invalid route';
        }
        break;

    case 'POST':
        if ($route === 'users') {
            $data = $_POST;
            $success = $userDAO->create($data);

            if ($success) {
                echo 'User created successfully';
            } else {
                echo 'Failed to create user';
            }
        } else {
            echo 'Invalid route';
        }
        break;

    case 'PUT':
        if (strpos($route, 'users/') === 0) {
            $userId = intval(substr($route, strlen('users/')));
            $user = $userDAO->getById($userId);

            if ($user) {
                parse_str(file_get_contents('php://input'), $putData);
                $success = $userDAO->update($userId, $putData);

                if ($success) {
                    echo 'User updated successfully';
                } else {
                    echo 'Failed to update user';
                }
            } else {
                echo 'User not found';
            }
        } else {
            echo 'Invalid route';
        }
        break;

    case 'DELETE':
        if (strpos($route, 'users/') === 0) {
            $userId = intval(substr($route, strlen('users/')));
            $user = $userDAO->getById($userId);

            if ($user) {
                $success = $userDAO->delete($userId);

                if ($success) {
                    echo 'User deleted successfully';
                } else {
                    echo 'Failed to delete user';
                }
            } else {
                echo 'User not found';
            }
        } else {
            echo 'Invalid route';
        }
        break;

    default:
        echo 'Invalid request method';
        break;
}

?>