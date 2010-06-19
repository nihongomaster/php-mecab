<?php
require_once 'PEAR/PackageFileManager2.php';
PEAR::setErrorHandling(PEAR_ERROR_DIE);
date_default_timezone_set('UTC');

// general package information
$channel        = '__uri';
$packagename    = 'mecab';
$summary        = 'The PHP bindings of the MeCab.';

$description    = $summary;

// information of cureent version
$version        = '0.4.1';
$apiversion     = '0.4.0';
$stability      = 'beta';
$apistability   = 'beta';

$notes = <<<EOS
- Initial release on PEAR channel.
EOS;

// set parameters to the package
$packagexml = new PEAR_PackageFileManager2;
$packagexml->setOptions(array(
    'baseinstalldir'    => '/',
    'packagedirectory'  => dirname(__FILE__),
    'filelistgenerator' => 'file',
    'ignore'    => array(
        'package.php',
        'package.xml',
        "{$packagename}-{$version}.tgz"),
    'dir_roles' => array(
        'tests'     => 'test',
        'manual'    => 'doc',
        'examples'  => 'data'),
    'exceptions'    => array(
        "{$packagename}.dsp"    => 'src',
        'CREDITS'       => 'doc',
        'EXPERIMENTAL'  => 'doc',
        'LICENSE'       => 'doc',
        'README'        => 'doc')));

$packagexml->setPackage($packagename);
$packagexml->setSummary($summary);
$packagexml->setNotes($notes);
$packagexml->setDescription($description);
$packagexml->setLicense('MIT License', 'http://www.opensource.org/licenses/mit-license.php');

$packagexml->setReleaseVersion($version);
$packagexml->setAPIVersion($apiversion);
$packagexml->setReleaseStability($stability);
$packagexml->setAPIStability($apistability);

$packagexml->addMaintainer('lead', 'rsky', 'Ryusuke SEKIYAMA,', 'rsky0711@gmail.com');

$packagexml->setPackageType('extsrc');
$packagexml->setProvidesExtension($packagename);
$packagexml->addConfigureOption('with-mecab', 'specify pathname to mecab-config', 'no');
$packagexml->setPhpDep('5.2.0');
$packagexml->setPearinstallerDep('1.4.1');

$packagexml->setChannel($channel);
$packagexml->generateContents();

// generate package.xml
if (php_sapi_name() == 'cli' && $argc > 1 && $argv[1] == 'make') {
    $make = true;
} elseif (!empty($_GET['make'])) {
    $make = true;
} else {
    $make = false;
}
// note use of debugPackageFile() - this is VERY important
if ($make) {
    $packagexml->writePackageFile();
    $data = file_get_contents('package.xml');
} else {
    $packagexml->debugPackageFile();
}
