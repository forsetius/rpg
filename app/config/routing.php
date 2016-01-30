<?php

// app/config/routing.php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Yaml\Parser;

// if this file exists - load it, else load all files from app/config/routing
$configFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'routing.yml';
$yaml = new Parser();
try {
    $routes = [];
    if (file_exists($configFile)) {
        $routes = $yaml->parse(file_get_contents($configFile));
    } else {
        $config = '';
        $files = dirname(__FILE__).DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR.'*.yml';
        foreach (glob($files) as $file) {
            $config .= file_get_contents($file) ."\n";
        }
        $routes = $yaml->parse($config);
    }
} catch (ParseException $e) {
    printf("Unable to parse the YAML string: %s", $e->getMessage());
}
$collection = new RouteCollection();
foreach ($routes as $name => $def) {
    $route = new Route($def['path']);
    foreach (['defaults','requirements','options','host','schemes','methods','condition'] as $opt) {
        $mtd = 'add'. ucfirst($opt);
        if(isset($def[$opt])) $route->$mtd($def[$opt]);
    }
    $collection->add($name, $route);
}
$collection->addRequirements(['_locale' => "%locale.available%"]);
$collection->addDefaults(['_locale'=>"%locale.default%"]);

return $collection;

 ?>
