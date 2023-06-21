<?php

function resizeImage($imgFile, $width, $height) {
    // Validate inputs
    if (!file_exists($imgFile)) {
        throw new Exception("Image file does not exist.");
    }
    if (!is_int($width) || $width <= 0 || !is_int($height) || $height <= 0) {
        throw new Exception("Invalid width or height.");
    }

    $imgInfo = getimagesize($imgFile);
    $imgType = $imgInfo["mime"];
    $orgImage = "";

    if ($imgType == "image/jpeg") {
        $orgImage = imagecreatefromjpeg($imgFile);
    } elseif ($imgType == "image/gif") {
        $orgImage = imagecreatefromgif($imgFile);
    } elseif ($imgType == "image/png") {
        $orgImage = imagecreatefrompng($imgFile);
    } else {
        throw new Exception("Invalid Image Format");
    }

    $desiredRatio = $width / $height;
    $sourceRatio = $imgInfo[0] / $imgInfo[1];

    if ($sourceRatio > $desiredRatio) {
        $temp_height = $height;
        $temp_width = (int)($height * $sourceRatio);
    } else {
        $temp_width = $width;
        $temp_height = (int)($width / $sourceRatio);
    }

    $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
    imagecopyresampled(
        $temp_gdim,
        $orgImage,
        0, 0,
        0, 0,
        $temp_width, $temp_height,
        $imgInfo[0], $imgInfo[1]
    );

    $x0 = ($temp_width - $width) / 2;
    $y0 = ($temp_height - $height) / 2;
    $desired_gdim = imagecreatetruecolor($width, $height);
    imagecopy(
        $desired_gdim,
        $temp_gdim,
        0, 0,
        $x0, $y0,
        $width, $height
    );

    $resizedImagePath = "resized_" . basename($imgFile);
    imagejpeg($desired_gdim, $resizedImagePath);

    // Clean up resources
    imagedestroy($orgImage);
    imagedestroy($temp_gdim);
    imagedestroy($desired_gdim);

    // Return the path or resource of the resized image if needed
    return $resizedImagePath;
}

function convertTimestamp($timestamp) {
    $when = "";
    $duration = time() - $timestamp;

    if ($duration < 60) {
        $when = $duration . " secs";
    } elseif ($duration < 3600) {
        $when = round($duration / 60, 0) . " mins";
    } elseif ($duration < 86400) {
        $when = round($duration / 3600, 0) . " hrs";
    } else {
        $when = date("d/m/Y", $timestamp);
    }

    return $when;
}

?>
