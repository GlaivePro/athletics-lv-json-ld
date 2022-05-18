<?php

// Procedurāla koda paraugs. Lai arī cenšamies dot korektus paraugus,
// garantiju nav, jo šis ir piemērs nevis praksē pārbaudīts kods.

// Funkcija, kas noformē laiku uz vajadzīgo hh:mm:ss.uuu
function formatTime($time)
{
	$s = floor($time); // sekundes
	$ms = round(1000 * ($time - $s)); // milisekundes
	// `round` lietots, lai izlīdzinātu peldošo skaitļu aritmētikas problēmas
	// labāk lietot speciālu paplašinājumu (piem bcmath) vai rīkus (DateInterval klasi, Carbon bibliotēku utt.)

	$m = floor($s / 60); // minūtes
	$s = $s - 60*$m;

	$h = floor($s / 60); // stundas
	$m = $m - 60*$h;

	return sprintf('%02d:%02d:%02d.%03d', $h, $m, $s, $ms);
}

// Funkcija, kas noformē vienu rezultātu
function prepareResult($result, $race)
{
  $participation = $result->participation;
  $person = $participation->person;
  
  return [
    '@type' => 'Result',

    // Unikāls identifikators šim rezultātam. Piemēram, URL uz rezultātu
    // vai norāde uz šo pašu rezultātu sarakstu un aiz # norāde uz
    // rezultāta ID vai, piemēram, dalībnieka numuru.
    '@id' => 'https://athletics.lv/race/'.$race->id.'.jsonld#'.$result->id,

    // Iegūtā vieta
    'rank' => $result->place,

    // Rezultātu sasniegušais dalībnieks
    'competitor' => [
      '@type' => 'Competitor',

      // Identifikators šim sacensību dalībniekam
      '@id' => 'https://athletics.lv/race/'.$race->id.'.jsonld#'.$result->id.'-competitor',

      // Dalībnieka numurs
      'bibIdentifier' => $participation->number,

      // Persona vai komanda
      'agent' => [
        // Sportists (varētu būt arī komanda - Team)
        '@type' => 'Athlete',

        // Personas identifikators. Var izmantot saiti uz personas
        // profilu vai fiktīvu saiti, kas satur kādu personas id.
        '@id' => 'https://athletics.lv/athlete/'.$person->id.'.jsonld',

        // Vārds
        'givenName' => $person->first_name,

        // Uzvārds
        'familyName' => $person->last_name,

        // Dzimums - Male vai Female
        'gender' => $person->gender === 'm' ? 'Male' : 'Female',

        // Nacionalitāte. Ar ISO 3166-1 alpha-3 kodu
        'nationality' => $person->country ? 'countrycode:'.$person->country->alpha3 : '',

        // Dzimšanas datums formātā GGGG-MM-DD
        'birthDate' => $person->date_of_birth,
      ],
    ],

    // Sniegums
    'performance' => [
      '@type' => 'TimePerformance',

      // Snieguma identifikators. Piemēram, rezultāta identifikators
      // ar papildus fragmentu, kas norāda, ka sniegums.
      '@id' => 'https://athletics.lv/race/'.$race->id.'.jsonld#'.$result->id.'-performance',

      // Laiks formātā hh:mm:ss.uuu
      'time' => formatTime($result->performance),
    ],
  ];
}

// Funkcija, kas sagatavo sacensību rezultātus
function raceResults($race)
{
  // Noformēto rezultātu saraksts
  $results = [];

  // Noformējam rezultātus un pievienojam sarakstam
  foreach ($race->results as $result)
    $results[] = prepareResult($result, $race);

  return [
    // Norāde uz izmantoto datu shēmu. Nav jāmaina.
    '@context' => 'https://w3c.github.io/opentrack-cg/contexts/opentrack.jsonld',

    // UnitRace - sacensība, kur rezultātus mēra kā laiku
    '@type' => 'UnitRace',

    // Unikāls identifikators šīm sacensībām. Ideālā gadījumā - šī paša rezultātu
    // saraksta URL
    '@id' => 'https://athletics.lv/race/'.$race->id.'.jsonld',

    // Sacensību rezultāti
    'results' => $results,
  ];
}

// Ielādējam rezultātus
$race = include '../race.php';

// Sagatavojam rezultātus
$results = raceResults($race);

// Iekodējam JSONā
$data = json_encode($results);

// Paziņojam klientam par datu tipu
header('Content-Type: application:ld+json');

// Nosūtām atbildi
echo $data;

exit;
