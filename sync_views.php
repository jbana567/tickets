<?php
$source = 'resources/views/post/page.blade.php';
$targets = [
    'resources/views/home.blade.php',
    'resources/views/inkomane.blade.php',
    'resources/views/welcome.blade.php'
];

foreach ($targets as $target) {
    if (copy($source, $target)) {
        echo "Successfully copied to $target\n";
    } else {
        echo "Failed to copy to $target\n";
    }
}
