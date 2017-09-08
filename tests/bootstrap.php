<?php
$findRoot = function ($root) {
    do {
        $lastRoot = $root;
        $root = dirname($root);
        if (is_dir($root . '/vendor/cakephp/cakephp')) {
            return $root;
        }
    } while ($root !== $lastRoot);
    throw new Exception("Cannot find the root of the application, unable to run tests");
};
$root = $findRoot(__FILE__);
unset($findRoot);
chdir($root);
if (file_exists($root . '/config/bootstrap.php')) {
    require $root . '/config/bootstrap.php';
    return;
}
require $root . '/vendor/cakephp/cakephp/tests/bootstrap.php';

Cake\Core\Configure::write('Encryption.key', '123456123456123456123456123456123456');
use Cake\Database\Type;
Type::map('encrypted', 'BryanCrowe\EncryptedType\Database\Type\EncryptedType');
