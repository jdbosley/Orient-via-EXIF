PHP-image-orient-via-EXIF
===============

PHP Script for Mobile Image Upload Orientation Correction via EXIF

Working on a responsive website which had image upload functionality I came across some issues with mobile image uploads. When images were uploaded to the website from a mobile device's camera roll they would often be incorrectly oriented, turned sideways, upside down, etc. After a little research I found out this is due to EXIF data attached to the image which records the device's orientation when taking the picture. After a little less research I found PHP's native exif_read_data() function. Here is a PHP function I wrote which reads an image's EXIF data and reorients the image to correct this problem. This function only works with .jpg images since PHP's exif_read_data() only works for .jpgs.
