<?php

$domain = "http://<YOUR DOMAIN>/<YOUR PATH>";
$link_dir = "a";
$redirect_dir = "redirectpage";

$link_url = $domain . "/" . $link_dir . "/";
$redirect_url = $domain . "/" . $redirect_dir;

function random($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function getPath($id)
{
    global $link_dir;
    return getcwd() . "/" . $link_dir . "/" . $id;
}

function isIdFree($id)
{
    if (is_dir(getPath($id))) {
        return FALSE;
    } else {
        return TRUE;
    }
}


function generateContent($url)
{

    global $redirect_url;

    //some html which will show an fullscreen iframe
    
    $content = "<head>";
    $content .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\"/>";
    $content .= PHP_EOL;
    $content .= "</head>";
    $content .= PHP_EOL;
    $content .= "<body style=\"margin:0px;padding:0px;overflow:hidden\">";
    $content .= PHP_EOL;
    $content .= "<iframe src=\"" . $redirect_url . "\" frameborder=\"0\" style=\"overflow:hidden;height:100%;width:100%\" height=\"100%\" width=\"100%\"></iframe>";
    $content .= PHP_EOL;
    $content .= "</body>";
    $content .= PHP_EOL;

    /*
     * php which will redirect to the url after a wait time
     * it is impossible to bypass the wait time as we are using php for the redirect (which is executed on the server side)
     */

    $content .= "<?php";
    $content .= PHP_EOL;
    $content .= "header(\"refresh:5;url=" . $url . "\");";


    return $content;
}

function getId()
{
    //Returns a random id which is not already used

    while (1) {

        $id = random(3);

        if (isIdFree($id)) {
            return $id;
        }

    }
}

function shortenLink($url)
{
    global $link_url;

    if (strpos($url, $link_url) !== false) {

        echo "Error: Link already shortened!";

    } else {

        $id = getId();
        $content = generateContent($url);
        $path = getPath($id);

        if (!mkdir($path, 0777, true)) {
            die('Error while creating link');
        }

        file_put_contents($path . "/index.php", $content, FILE_APPEND | LOCK_EX);

        echo $link_url . $id;
    }


}
