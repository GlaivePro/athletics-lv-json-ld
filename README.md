# Datu apmaiņas formāts ar athletics.lv

*athletics.lv* datus nodod un saņem, izmantojot datu struktūras, kas paredzētas
[Open Athletics Data Model](https://w3c.github.io/opentrack-cg/spec/model/) standartā,
kurš savukārt izmanto JSON-LD formātu.

## Datu paraugi

- [Skrējiena rezultāti](https://athletics.lv/race/27306.jsonld)
- [Sportists](https://athletics.lv/athlete/3620.jsonld)
- [Persona](https://athletics.lv/person/13569.jsonld)
- [Dalībnieks](https://athletics.lv/competitor/308756.jsonld)
- [Dalībnieks bez numura](https://athletics.lv/competitor/54044.jsonld)
- [Rezultāts](https://athletics.lv/result/340065.jsonld)

Citus paraugus var aplūkot OpenTrack grupas [repozitorijā](https://github.com/w3c/opentrack-cg/tree/main/examples).

## Datu struktūra

Katrs objekts (gan atbildes augstākā līmeņa, gan iekšā iekļautie, piemēram, "sportists")
satur identifikatoru `@id` un objekta tipu `@type`.

Kā identifikatoru vislabāk izmantot konkrētā objekta URL. Piemēram, personas, kas atrodama
adresē https://athletics.lv/person/13569.jsonld identifikators ir `https://athletics.lv/person/13569.jsonld`.

Ne vienmēr tas iespējams. Piemēram, rezultātā https://athletics.lv/result/340065.jsonld ir sniegums,
kurš nav atverams kā atsevišķs objekts. Šādā gadījumā labi izmantot virsējā objekta URL, tam galā
pieliekot `#` un kādu norādi uz apakšobjektu. Šajā gadījumā tas ir rezultāta sniegums (*performance*),
tāpēc identifikators ir `https://athletics.lv/result/340065.jsonld#performance`. Tieši `#` izmantojam
tāpēc, ka tas nemaina iegūstamo resursu — pieprasījums uz https://athletics.lv/result/340065.jsonld#performance
atver to pašu https://athletics.lv/result/340065.jsonld, kas satur šo sniegumu.

Daļu aiz `#` var arī veidot detalizētāk, piemēram, ja nav URL individuāliem rezultātiem, tad sacensību
ietvaros rezultāta identifikators var būt `https://athletics.lv/race/3465.jsonld#340065`, bet snieguma
identifikators šim rezultātam: `https://athletics.lv/race/3465.jsonld#340065-performance`.

Var izmantot arī fiktīvus URL. Piemēram, athletics.lv pagaidām nav treneru JSON-LD kartiņas, bet vienalga
var norādīt treneri, izmantojot personas ID, piemēram, `https://athletics.lv/coach/3620.jsonld`, kaut šāds
URL ne uz ko neved.

Identifikatoru `@id` var nenorādīt gadījumos, kad informācijai nav nekādas nozīmes ārpus konteksta.
Piemēram, vēja ātrums pie kāda no lēcieniem. Bet to obligāti vajag norādīt visiem objektiem, kas var 
parādīties vairākos kontekstos. Piemēram, personas, rezultāti.

Datiem (HTTP atbildei vai failam) jāsatur viens augstākā līmeņa objekts. Šajā objektā 
jānorāda arī `@context` parametrs ar vērtību `https://w3c.github.io/opentrack-cg/contexts/opentrack.jsonld`,
kas norāda, ka datos izmantots Open Athletics Data Model.

Atbildes datu tipam ieteicams būt `application/ld+json` vai `application/json`.

### Skrējiens (`UnitRace`)

Struktūra:
- `@id` unikāls identifikators
- `@type` tips `UnitRace`
- `results` masīvs ar [rezultātiem](#rezultāts-result)

Paraugs: https://athletics.lv/race/27306.jsonld

### Rezultāts (`Result`)

Struktūra:
- `@id` unikāls identifikators
- `@type` tips `Result`
- `rank` skrējienā gūtā vieta
- `competitor` [dalībnieks](#dalībnieks-competitor)
- `performance` sniegums [laika](#laika-sniegums-timeperformance), 
[punktu](#punktu-sniegums-pointsperformance) vai [attāluma](#attāluma-sniegums-distanceperformance) izteiksmē.

Paraugs: https://athletics.lv/result/34064.jsonld

### Dalībnieks (`Competitor`)

Struktūra:
- `@id` unikāls identifikators
- `@type` tips `Competitor`
- `agent` [sportists](#sportists-athlete) vai [komanda](#komanda-team)

Paraugs: https://athletics.lv/competitor/308756.jsonld)

### Sportists (`Athlete`)

Struktūra:
- `@id` unikāls identifikators
- `@type` tips `Team`
- (neobligāts) `name` pilns vārds un uzvārds
- `givenName` vārds
- `familyName` uzvārds
- `gender` dzimums `Male` vai `Female`
- (neobligāts) `nationality` pārstāvētā valsts, ieteicams formātā `countrycode:ZZZ`, kur *ZZZ* — valsts [ISO 3166-1 alpha-3](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-3) kods. Formāts `countrycode:LVA` ir ekvivalents šādai norādei: `http://publications.europa.eu/resource/authority/country/LVA`.
- `birthDate` dzimšanas datums ISO 8601 formātā `GGGG-MM-DD`, piemēram, `1988-11-23`.

Paraugs: https://athletics.lv/athlete/3620.jsonld

### Komanda (`Team`)

Struktūra:
- `@id` unikāls identifikators
- `@type` tips `Team`
- `name` komandas nosaukums
- `athlete` masīvs ar komandas [sportistiem](#sportists-athlete)

### Laika sniegums (`TimePerformance`)

Struktūra:
- `@id` unikāls identifikators
- `@type` tips `TimePerformance`
- `time` laiks ISO 8601 formātā `hh:mm:ss.uuu`, piemēram, `01:23:53.000` vai `00:00:12.214`.

Paraugs: `performance` atribūtā šajā objektā https://athletics.lv/result/34064.jsonld#performance

### Punktu sniegums (`PointsPerformance`)

Struktūra:
- `@id` unikāls identifikators
- `@type` tips `PointsPerformance`
- `points` gūto punktu skaits

### Distances sniegums (`DistancePerformance`)

Struktūra:
- `@id` unikāls identifikators
- `@type` tips `DistancePerformance`
- `distance` distances [vērtība](#vērtība-quantitativevalue)

### Vērtība (`QuantitativeValue`)

Struktūra:
- `@type` tips `QuantitativeValue`
- `unitCode` mērvienība, piemēram MTR (metri) vai KGM (kilogrami)
- `value` vērtība lielums norādītajās mērvienībās

## Realizācijas paraugi

- Procedurāla koda paraugs valodā PHP: https://github.com/GlaivePro/athletics-lv-json-ld/blob/master/examples/php-proc/export.php
