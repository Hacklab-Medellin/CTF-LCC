<?php

include("./Config/vars.php");

//// CODE

if (!isset($w))
    {
    $w = 50;
    }

if (!isset($h))
    {
    $h = 50;
    }


SetType($mode,   'integer');
SetType($w,      'integer');
SetType($h,     'integer');
SetType($img,     'string' );

function percent($p, $w)
    {
    return (real)(100 * ($p / $w));
    }

function unpercent($percent, $whole)
    {
    return (real)(($percent * $whole) / 100);
    }

// Initialization
print $img;
// Make sure the file exists...
if (!file_exists($img))
    {
    echo "Error: could not find file: $img.";
    exit();
    }

// If the user defined a type to use.
if (!isset($type))
    {
    $ext = explode('.', $img);
    $ext = $ext[count($ext)-1];
        switch(strtolower($ext))
            {
            case 'jpeg'  :
                $type = 'jpg';
            break;
            default :
                $type = $ext;
            break;
            }
    }

// Create the image...
switch (strtolower($type))
    {
    case 'jpg':
        $tmpgif = GetImageSize($img);
    break;

    case 'gif':
        $tmpgif = GetImageSize($img);
    break;

    case 'png':
        $tmp = GetImageSize($img);
    break;

    default:
        echo 'Error: Unrecognized image format.';
        exit();
    break;
    }

if($tmpgif)
    {
    // Resize it

    $ow  = $tmpgif[0];    // Original image width
    $oh  = $tmpgif[1];    // Original image height

    if ($mode)
        {
        // Just smash it up to fit the dimensions
        $nw = $w;
        $nh = $h;
        }
    else
        {
        // Make it proportional.
        if ($ow > $oh)
            {
            $nw  = $w;
            $nh = unpercent(percent($nw, $ow), $oh);
            }
        else if ($oh > $ow)
            {
            $nh = $h;
            $nw = unpercent(percent($nh, $oh), $ow);
            }
        else
            {
            $nh = $h;
            $nw = $w;
            }
        }
	if ($which == "Image1") {
	$whichhid = "image_one";
	}
	if ($which == "Image2") {
	$whichhid = "image_two";
	}
	if ($which == "Image3") {
	$whichhid = "image_three";
	}
	if ($which == "Image4") {
	$whichhid = "image_four";
	}
	if ($which == "Image5") {
	$whichhid = "image_five";
	}
	$wid = explode("age",$which);
	$id = $wid[1];
	$imgnew = $img;

	$out = "<HTML>\n";
	$out .= "<HEAD>\n";
	$out .= "<script language=\"JavaScript\">\n";
	$out .= "<!--\n";
	$out .= "function newDone() {\n";
	
	$out .= "opener.document.images[\"$which\"].src = \"$imgnew\";\n";
	$out .= "opener.document.items.$whichhid.value = \"$imgnew\";\n";
	$out .= "opener.document.images[\"$which\"].height = $nh;\n";
	$out .= "opener.document.images[\"$which\"].width = $nw;\n";
	$out .= "opener.Load" . $id . "();\n";
	$out .= "window.close();\n";
	$out .= "}\n";
	$out .= "// -->\n";
	$out .= "</script>\n";
	$out .= "</HEAD>\n";
	$out .= "<BODY onLoad=\"newDone()\">\n";
	$out .= "</BODY>\n";
	$out .= "</HTML>\n";
	//$out .= "<img src=\"$img\" height=\"$nh\" width=\"$nw\">";
    }
else                  
    {
    echo 'Could not create image resource.';
    exit;
    }


if ($out)
    {
    print $out;
    //imagedestroy($out);
    }
else
    {
    echo 'ERROR: Could not create resized image.';
    }

?>
