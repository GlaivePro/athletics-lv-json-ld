<?php

include_once 'JsonldResource.php';
include_once 'JsonldResponse.php';

foreach (glob("Resources/*.php") as $filename)
    include_once $filename;

// Objektorientēta koda paraugs. Lai arī cenšamies dot korektus paraugus,
// garantiju nav, jo šis ir piemērs nevis praksē pārbaudīts kods.

// Ielādējam rezultātus
$race = include '../race.php';
$results = new Resources\Race($race);

// Atgriežam Jsonld rezultātus
$response = new JsonldResponse($results);
return $response->respond();
