<?php


use PHPUnit\Framework\TestCase;
use Diogof648\SimplePhpRouter\Router;

class TestRouter extends TestCase
{
    public function testCanMakeGetRequest()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';

        ob_start();
        Router::get('/', function () {
            echo "Good";
        });
        $output = ob_get_clean();

        $this->assertEquals("Good", $output);
    }

    public function testCanMakePostRequest()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/';

        ob_start();
        Router::post('/', function () {
            echo "Good";
        });
        $output = ob_get_clean();

        $this->assertEquals("Good", $output);
    }

    public function testCanMakePatchRequest()
    {
        $_SERVER['REQUEST_METHOD'] = 'PATCH';
        $_SERVER['REQUEST_URI'] = '/';

        ob_start();
        Router::patch('/', function () {
            echo "Good";
        });
        $output = ob_get_clean();

        $this->assertEquals("Good", $output);
    }

    public function testCanMakePutRequest()
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $_SERVER['REQUEST_URI'] = '/';

        ob_start();
        Router::put('/', function () {
            echo "Good";
        });
        $output = ob_get_clean();

        $this->assertEquals("Good", $output);
    }

    public function testCanMakeDeleteRequest()
    {
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $_SERVER['REQUEST_URI'] = '/';

        ob_start();
        Router::delete('/', function () {
            echo "Good";
        });
        $output = ob_get_clean();

        $this->assertEquals("Good", $output);
    }

    public function testCanHandleAny()
    {
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $_SERVER['REQUEST_URI'] = '/';

        ob_start();
        Router::any('/', function () {
            echo "Good";
        });
        $output = ob_get_clean();

        $this->assertEquals("Good", $output);
    }

    public function testCanHandleMethodOverwriting()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/';
        $_POST['_method'] = 'PATCH';

        ob_start();
        Router::patch('/', function () {
            echo "Good";
        });
        $output = ob_get_clean();

        $this->assertEquals("Good", $output);
    }

    public function testCanShow404PreMadePage()
    {
        ob_start();
        Router::noMatch();
        $output = ob_get_clean();

        $this->assertEquals("<h1>Error - 404</h1>", $output);
    }

    public function testCanShowPersonalized404()
    {
        ob_start();
        Router::noMatch(function () {
            echo "Not Found";
        });
        $output = ob_get_clean();

        $this->assertEquals("Not Found", $output);
    }

    public function testCanMakeRequestLongURI()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/hello/are/you/good';

        ob_start();
        Router::get('/hello/are/you/good', function () {
            echo "Good";
        });
        $output = ob_get_clean();

        $this->assertEquals("Good", $output);
    }

    public function testCanMakeRequestWithParams()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/hello/1';

        ob_start();
        Router::get('/hello/{id}', function ($id) {
            echo "Good " . $id;
        });
        $output = ob_get_clean();

        $this->assertEquals("Good 1", $output);
    }

    public function testReturnsEmptyIfLongURIDoesntCorrespond()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/hello/are/you/notgood';

        ob_start();
        Router::get('/hello/are/you/good', function () {
            echo "Good";
        });
        $output = ob_get_clean();

        $this->assertEquals("", $output);
    }

    public function testReturnsEmptyIfURIDoesntCorrespond()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/notgood';

        ob_start();
        Router::get('/', function () {
            echo "Should not be seen";
        });
        $output = ob_get_clean();

        $this->assertEquals("", $output);
    }

    public function testShouldReturn500IfErrorCallback()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';

        ob_start();
        Router::get('/', 1);
        $output = ob_get_clean();

        $this->assertEquals("<h1>Error - 500</h1>", $output);
    }
}
