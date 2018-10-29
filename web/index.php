<?php

$name = '';

switch ($_SERVER['REQUEST_URI']) {
    case '/info':
        phpinfo();
        break;
    case '/':
        $content = [];

        if (!empty($name)) {
            $content[] = "<h1>Hello, $name!</h1>";
        } else {
            $content[] = "<h1>Hello, friend!</h1>";
        }

        $content[] = '<p>You are running <a href="/info">PHP ' . phpversion() . '</a>.</p>';

        if (class_exists('Redis')) {
            try {
                $redis = new Redis();
                @$redis->connect('tutorial-redis', 6379);
                $num_times = $redis->incr('num_times') ?: 0;

                $content[] = "<p>This page has been loaded $num_times times.</p>";
            } catch (Exception $e) {
                $content[] = "<p>I'd tell you how many times this page has been loaded, but I can't connect to Redis!</p>";
            }
        } else {
            $content[] = "<p>I'd tell you how many times this page has been loaded, but I don't have Redis installed!</p>";
        }

        $content[] = '<img src="/dank.gif" style="max-width: 200px; max-height: 200px;" alt="The dankest of gifs">';

        $content = implode("\n", $content);

        echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
$content
</body>
</html>
HTML;
        break;
    case '/dank.gif':
        // signal to parent process to output requested file verbatim
        if (is_file('dank.gif')) {
            return false;
        }
        // otherwise, fall through
    default:
        header('HTTP/1.1 404 Not Found');
        exit();
}
