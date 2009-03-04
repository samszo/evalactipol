<?php

// Include the package
require_once('../Lite.php');

// Set a id for this cache
$id = '123';

// Set a few options
$options = array(
    'cacheDir' => '/tmp/',
    'lifeTime' => 3600
);

// Create a Cache_Lite object
$Cache_Lite = new Cache_Lite($options);

// Test if thereis a valide cache for this id
if ($data = $Cache_Lite->get($id)) {

    echo "Cache hit !";
    // Content is in $data
    // (...)

} else { // No valid cache found (you have to make the page)

    // Cache miss !
    echo "Put in $data datas to put in cache";
    // (...)
    $Cache_Lite->save($data);

}

if ($data = $Cache_Lite->get('block1')) {
    echo($data);
} else { 
    $data = 'Data of the block 1';
    $Cache_Lite->save($data);
}

echo('<br><br>Non cached line !<br><br>');

if ($data = $Cache_Lite->get('block2')) {
    echo($data);
} else { 
    $data = 'Data of the block 2';
    $Cache_Lite->save($data);
}


?>

