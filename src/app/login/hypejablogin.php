<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app->get(
    '/hypejablogin',
    function (Request $request, Response $response) {
        session_start();
        if (isset($_SESSION['user'])) {
            header("Location: /loginPoll");
            die();
        }
        $html = file_get_contents(__DIR__ . "/../resources/hypejab-login/hypejablogin.html");
        $response->getBody()->write($html);
        return $response->withHeader("content-type", "text/html")
                        ->withStatus(200);
    }
);


$app->get(
    '/hypejablogin2',
    function (Request $request, Response $response) {
        session_start();
        if (isset($_SESSION['user'])) {
            header("Location: /loginPoll");
            die();
        }
        $html = file_get_contents(__DIR__ . "/../resources/hypejab-login/hypejablogin2.html");
        $response->getBody()->write($html);
        return $response->withHeader("content-type", "text/html")
                        ->withStatus(200);
    }
);


$app->get(
    '/hypejablogin3',
    function (Request $request, Response $response) {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            // If no username provided, present the auth challenge.
            header('WWW-Authenticate: Basic realm="My Website"');
            header('HTTP/1.0 401 Unauthorized');
            // User will be presented with the username/password prompt
            // If they hit cancel, they will see this access denied message.
            echo '<p>Access denied. You did not enter a password.</p>';
            exit; // Be safe and ensure no other content is returned.
        }
        
        // If we get here, username was provided. Check password.
        if ($_SERVER['PHP_AUTH_PW'] == 'heisenberg') {
            session_start();
            $_SESSION['user'] = 'Heisenberg';
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
            header("Location: /loginPoll");
            die();
        } else {
            $response->getBody()->write('Wrong username or password.');
            return $response->withHeader("content-type", "text/html")
                            ->withStatus(200);
        }
    }
);


$app->post(
    '/hypejabloginpassword',
    function (Request $request, Response $response) {

        if ($_POST['username'] == 'say+my+name@bb.com') {
            session_start();
            if (isset($_SESSION['user'])) {
                header("Location: /loginPoll");
                die();
            }
            $html = file_get_contents(__DIR__ . "/../resources/hypejab-login/hypejabloginpassword.html");
            $response->getBody()->write($html);
            return $response->withHeader("content-type", "text/html")
                            ->withStatus(200);
            die();
        } else {
            $response->getBody()->write('Wrong username');
            return $response->withHeader("content-type", "text/html")
                            ->withStatus(200);
        }

    }
);

$app->post(
    '/hypejablogout',
    function (Request $request, Response $response) {
        session_start();
        if (isset($_SESSION['user'])) {
            session_destroy();
            if (isset($_SESSION['logindif'])) {
                header("Location: /hypejablogin2");
            } else {
                header("Location: /hypejablogin");
            }
            die();
        } else {
            header("Location: /loginPoll");
            die();
        }
        $response->getBody()->write('Logging out...');
        return $response->withHeader("content-type", "text/html")
                        ->withStatus(200);
    }
);

$app->post(
    '/loginVerify',
    function (Request $request, Response $response) {
        if ($_POST['username'] == 'say+my+name@bb.com' && $_POST['password'] == 'heisenberg') {
            session_start();
            $_SESSION['user'] = 'Heisenberg';
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
            header("Location: /loginPoll");
            die();
        } else {
            $response->getBody()->write('Wrong username or password.');
            return $response->withHeader("content-type", "text/html")
                            ->withStatus(200);
        }
    }
);


$app->post(
    '/loginVerify2',
    function (Request $request, Response $response) {
        if ($_POST['password'] == 'heisenberg') {
            session_start();
            $_SESSION['user'] = 'Heisenberg';
            $_SESSION['logindif'] = 'true';
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
            header("Location: /loginPoll");
            die();
        } else {
            $response->getBody()->write('Wrong password.');
            return $response->withHeader("content-type", "text/html")
                            ->withStatus(200);
        }
    }
);