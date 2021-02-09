<?php

use System\Files\File;

define('FILE_PERMISSIONS', 0644);
define('DIR_PERMISSIONS', 0755);

File::setPath($_ROOT_DIRECTORY . '/upload/');
