<?php
#
# Shadowbox Plugin for Uploaded Images
#
# Version: 0.3
# Author: Reto Hugi  (http://hugi.to/blog/)
# License: GPL v3 (http://www.gnu.org/licenses/gpl.html)
#
# For more information see the help sections at the end of this file.
# Based on and inspired by the ImageGallery Plugin by Russ Baldwin.
#
# Changelog:
# see below


function smarty_cms_function_Boxifier($params, &$smarty) {

    $galleryTitle = "Gallery";
    $picFolder = 'uploads/images/';  //path to pics, ending with /
    $ulClass = 'picturelist'; // Set the wrapping div id to allow you to have different CSS for each gallery.
    $sortBy = 'name'; //Sort image files by 'name' or 'date'
    $sortByOrder = 'asc'; //Sort image files in ascending order: 'asc' or decending order: 'desc'
    $bigPicCaption = 'name'; // either 'name', 'file', 'number' or 'none', Sets caption above big image.
    $thumbPicCaption = 'name'; // either 'name', 'file', 'number' or 'none', Sets caption below thumbnails
    $bigPicAltTag = 'name'; // either 'name', 'file', 'number'. Sets alt tag - compulsory
    $bigPicTitleTag = 'name'; // either 'name', 'file', 'number' or 'none'. Sets title tag or removes it
    $thumbPicAltTag = 'name'; // either 'name', 'file', 'number'. Sets alt tag - compulsory
    $thumbPicTitleTag = ''; // either the default or 'name', 'file', 'number' or 'none'. Sets title tag or removes it

    if(isset($params['ulClass'])) $ulClass = $params['ulClass'];
    if(isset($params['picFolder'])) $picFolder = $params['picFolder'];
    if(isset($params['sortBy'])) $sortBy = $params['sortBy'];
    if(isset($params['sortByOrder'])) $sortByOrder = $params['sortByOrder'];
    if(isset($params['gTitle'])) $galleryTitle = $params['gTitle'];

    //Read Image Folder
    $selfA = explode('/', $_SERVER["PHP_SELF"]);
    $self = $selfA[sizeOf($selfA)-1] . '?page=' . $_GET['page'];
    if( !is_dir($picFolder) || !is_readable($picFolder) ) return;

    $picDir = dir($picFolder);
    $list = array();
    while($check = $picDir->read()) {
        if(strpos($check,'.jpg') || strpos($check,'.JPG') || strpos($check,'.jpeg')
            || strpos($check,'.JPEG') || strpos($check,'.gif') || strpos($check,'.GIF')
            || strpos($check,'.png') || strpos($check,'.PNG'))  {

            $cThumb = explode("_", $check);
            if($cThumb[0] != "thumb" && $cThumb[0] != "editor") {
                $list[] = $check;
            }
        }
    }

    //Sort by date
    if($sortBy == "date") {
        $tmp = array();
        foreach($list as $k => $v) {
            $tmp['file'][$k] = $v;
            $tmp['date'][$k] = filemtime($picFolder . $v);
        }

        //Sort by Order
        ($sortByOrder == 'desc') ? array_multisort($tmp['date'], SORT_DESC, $tmp['file'], SORT_DESC) : array_multisort($tmp['date'], SORT_ASC, $tmp['file'], SORT_ASC);
        $list = $tmp['file'];
    }
    else ($sortByOrder == 'desc') ? rsort($list) : sort($list);

    //Output
    $count = 1;
    $output = '';

    //thumbcount
    $deci = array();
    for($i=1; $i<=sizeof($list); $i++) {
        $deci[$i] = $i;
        while( strlen($deci[$i]) < strlen(sizeof($list)) ) $deci[$i] = '0' . $deci[$i];
    }

     
    // thumb generation
    $output .= '<ul class="'.$ulClass.'">'. "\n";
    $i = 1;
    foreach($list as $key => $value) {
        $bigPic = $picFolder . $value;
        //list($bigPicWidth, $bigPicHeight) = getImageSize($bigPic);
        $thumbPic = $picFolder . 'thumb_' . $value;
        $thumbSize = @getImageSize($thumbPic) or ($thumbSize[0] = 96) and ($thumbSize[1] = 96);
        $path_parts = pathinfo($bigPic);
        $extension = '.' . $path_parts['extension'];
        $ImageFileName = basename($bigPic); 
        $bigPicName = basename($bigPic, $extension);

        $output .= '<li class="thumb">';
        $output .= '<a href="' . $bigPic . '" rel="lightbox-'.$galleryTitle.'" title="' . $bigPicName . '">' . "\n";

        //Set Image
        $output .= '<img src="' . $thumbPic .'" alt="' . $bigPicName . '" />';

        //Close tags
        $output .='</a></li>' . "\n";
        
    }
    
    $output .= '</ul>' . "\n" . '<div style="clear:both"></div>' . "\n";

    return $output;
}

function smarty_cms_help_function_Boxifier() {
    echo <<<EOF
    <p>
        Boxifier builds a thumbnail listing out of an image folder and provides 
        integration with Shadowbox.<br/>
        Usage:<br/>
        <code>{boxifier picFolder="uploads/images/yourFolder"}
    </p>
    <h2>Options</h2>
    <ul>
        <li><strong>gTitle</strong>: sets the Title of the Gallery [default=Gallery]</li> 
        <li><strong>ulClass</strong>: sets the html class for the UL element [Default=picturelist]</li> 
        <li><strong>picFolder</strong>: sets the path to the image folder</li>
        <li><strong>sortBy</strong>: use sortby="name" to sort alphabetically or "date" to sort by last modified date [Default=name]</li>
        <li><strong>sortByOrder</strong>: use <strong>asc</strong> to sort ascending
            or <strong>desc</strong> to sort descending. (only makes sense in 
            combination with the parameter <i>sortBy</i>) [Default=asc]</li>
    </ul>
EOF;
}


function smarty_cms_about_function_Boxifier() {
    echo <<<EOF
    <p>Author: <a href="http://hugi.to">Reto Hugi</a></p>
    <p>Version: <strong>0.3</strong></p>
    <p>
    Change History:<br/>
    <strong>Version 0.3</strong> - switched from shadowbox to slimbox2<br/>
    <strong>Version 0.2</strong> - code cleanup<br/>
    <strong>Version 0.1</strong> - First release as a Plugin (Tag)<br/>
    </p>

EOF;
}

?>
