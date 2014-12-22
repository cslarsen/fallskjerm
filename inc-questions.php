<?

// seed PRNG for shuffle() usage
srand((float)microtime() * 1000000);

$_id = '$Id: inc-questions.php 160 2008-05-26 10:56:27Z csl $';
$url_handbok = "http://www.nlf.no/fallskjerm/html/su/haandbok/haandbokfnlf.html";

// viser hvilke deler fra h�ndboka som du m� ha tatt
// teoripr�ve i.  Feks de som skal ta A-sert m� lese del 100, 200, 500
$_sertifikat_teorikrav = array(
	'A' => array(100, 200, 500),
	'B' => array(100, 200, 300, 400, 500),
	'C' => array(100, 200, 300, 400, 500),
	'D' => array(100, 200, 300, 400, 500, 600),
);

function get_chapter_name($chapter_number)
{
	switch ( "$chapter_number" ) {
	case '000':	return 'Organisasjon';
	case '100':	return 'Sikkerhetsbestemmelser';
	case '200':	return 'Materiellreglement';
	case '300':	return 'Fallskjermsertifikater';
	case '400':	return 'Instrukt�rlisenser';
	case '500':	return 'Operative Bestemmelser';
	case '600':	return 'Oppl�ringsprogram';
	default:	return 'Ukjent kapittel';
	}
}

function get_question_chapter($chapter)
{
	switch ( $chapter[0] ) {
	case '0':	return "000";
	case '1':	return "100";
	case '2':	return "200";
	case '3':	return "300";
	case '4':	return "400";
	case '5':	return "500";
	case '6':	return "600";
	default:	return "Ukjent";
	}
}

function get_question_with_id($id)
{
	global $_questions;

	foreach ( $_questions as $q ) {
		if ( $q['id'] == $id )
			return $q;
	}

	return array();
}

function get_covered_chapters()
{
	global $_questions;
	$r = array();

	foreach ( $_questions as $q ) {

		$chapters = $q['chapter'];
		if ( gettype($chapters) != "array" )
			$chapters = array($chapters);

		foreach ( $chapters as $chapter ) {
			$chapter = get_question_chapter($chapter);
			if ( !in_array($chapter, $r) )
				$r[] = $chapter;
		}
	}

	sort($r);
	return $r;
}

function get_covered_chapters_frequency()
{
	global $_questions;
	$r = array();

	foreach ( $_questions as $q ) {
		$chapters = $q['chapter'];

		if ( gettype($chapters) != "array" )
			$chapters = array($chapters);

		foreach ( $chapters as $chapter ) {
			$chapter = get_question_chapter($chapter);
			if ( !isset($r[$chapter]) )
				$r[$chapter] = array($chapter, 0);

			$r[$chapter] = array($chapter, $r[$chapter][1] + 1);
		}
	}

	sort($r);
	return $r;
}

function pick_random_questions($number_of_questions)
{
	global $_questions;

	$copy = $_questions;
	shuffle($copy);

	if ( count($copy) > $number_of_questions )
		$copy = array_splice($copy, 0, $number_of_questions);

	return $copy;
}

function get_questions()
{
	global $_questions;
	$copy = $_questions;
	return $copy;
}

$_questions = array(

array(
	'id'		=> 0,
	'question'	=> 'Hvem skal <i>forsikre</i> seg (alts� ikke <i>ansvar</i>) for at det finnes egnet kniv i flyet ?',
	'alternatives'	=> array('HM', 'HFL', 'HL', 'HI'),
	'answer'	=> array(0),
	'chapter'	=> '508.5.1',
),

array(
	'id'		=> 1,
	'question'	=> 'Hvem skal orientere flyger om utsprangsh�yde, innflygingsretning, driverkast, m.m. ?',
	'alternatives'	=> array('HM', 'HFL', 'HL', 'HI'),
	'answer'	=> array(0),
	'chapter'	=> '508.5.1',
),

array(
	'id'		=> 2,
	'question'	=> 'Hva er den formelt riktige definisjonen p� frittfall ?',
	'alternatives'	=> array('Et hopp der hopperen selv utl�ser sin skjerm etter at han har forlatt luftfart�yet.',
				 'Ethvert fallskjermhopp.',
				 'Et hopp der elevens skjerm blir utl�st av en line koblet til flyet.',
				 'Ethvert hopp fra et luftfart�y i den hensikt � benytte en fallskjerm.'),
	'answer'	=> array(0),
	'chapter'	=> '300.1',
),

array(
	'id'		=> 3,
	'question'	=> 'Hva er minste sertifikatklasse du m� ha for � delta i nasjonale og internasjonale konkurranser ?',
	'alternatives'	=> array('A', 'B', 'C', 'D'),
	'answer'	=> array(1),
	'chapter'	=> '309.2',
),

array(
	'id'		=> 4,
	'question'	=> 'Hvilke regler gjelder for attestering i andres hopplog n�r du har B-sertifikat ?',
	'alternatives'	=> array(
		'Kan ikke attestere i andres hopplog',
		'Kan attestere for andre hoppere med A-sertifikat eller h�yere',
		'Kan attestere for andre hoppere med B-sertifikat eller h�yere, dog ikke spesielle progresjonshopp ' .
			'som skal kontrolleres av instrukt�r',
		'Kan attestere for andre hoppere med A-sertifikat eller h�yere, dog ikke spesielle progresjonshopp ' .
			'som skal kontrolleres av instrukt�r',
		),
	'answer'	=> array(3),
	'chapter'	=> '309.2',
),

array(
	'id'		=> 5,
	'question'	=> 'Hva betegnes en innehaver av B-sertifikat ?',
	'alternatives'	=> array(
				'Solo frittfall hopper / parachutist',
				'Hoppfeltleder / freefall parachutist',
				'Hoppmester / experienced parachutist',
				'Hoppleder / senior parachutist',
		),
	'answer'	=> array(1),
	'chapter'	=> '309.2',
),

array(
	'id'		=> 6,
	'question'	=> 'Hvem utpeker HL for dagen ?',
	'alternatives'	=> array('HFL', 'SU', 'HI', 'Utpekes via stemmer'),
	'answer'	=> array(2),
	'chapter'	=> '502.5',
),

array(
	'id'		=> 7,
	'question'	=> 'Hvem har som oppgave � utpeke HFL ?',
	'alternatives'	=> array('HI', 'HL', 'HM', 'Den nyeste hopperen som har minimum A-sertifikat m� v�re HFL'),
	'answer'	=> array(1),
	'chapter'	=> '502.6',
),

array(
	'id'		=> 8,
	'question'	=> 'Hvem er det som m� kjenne til de operative bestemmelsene i h�ndbokas del 500 ?',
	'alternatives'	=> array('Kun hoppmestere', 'Hoppmester, hoppleder og HI', 'Ethvert klubbmedlem som deltar i praktisk hoppvirksomhet',
				'Alle som deltar i praktisk hoppvirksomhet utenom elever'),
	'answer'	=> array(2),
	'chapter'	=> '502.9',
),

array(
	'id'		=> 9,
	'question'	=> 'Har du lov � hoppe fallskjerm n�r du er HFL ?',
	'alternatives'	=> array('Ja', 'Nei'),
	'answer'	=> array(1),
	'chapter'	=> '502.10',
),

array(
	'id'		=> 10,
	'question'	=> 'Hva menes med <i>hopping av st�rre omfang</i> ?',
	'alternatives'	=> array(
				'Mer enn 5 hopp per dropp, mer enn 25 hopp totalt og/eller aktivitet utover 24 timer',
				'Mer enn 10 hopp per dropp, mer enn 50 hopp totalt og/eller aktivitet utover 24 timer',
				'Mer enn 20 hopp per dropp, mer enn 100 hopp totalt og/eller aktivitet utover 24 timer',
				'Mer enn 30 hopp per dropp, mer enn 150 hopp totalt og/eller aktivitet utover 24 timer',
			),
	'answer'	=> array(2),
	'chapter'	=> '504.2',
),

array(
	'id'		=> 11,
	'question'	=> 'Hva st�r AFF for ?',
	'alternatives'	=> array('Active Free Fall', 'Accelerated Free Fall', 'Authorized Free Fall', 'Abandoned Free Fall'),
	'answer'	=> array(1),
	'chapter'	=> '100.1',
),

array(
'id' => 12,
'question' => 'Hva menes med AGL ?',
'alternatives' => array('Virkelig h�yde over bakken', 'Virkelig h�yde over havet', 'Virkelig hastighet i frittfall', 'Virkelig hastighet til flyet'),
'answer' => array(0),
'chapter' => '100.1',
),

array(
'id' => 1200, // was 12 = duplicate id
'question' => 'Hva st�r CF for ?',
'alternatives' => array('Canopy Formation', 'Canopy Freestyle', 'Canopy Fixture', 'Canopy Formula 1'),
'answer' => array(0),
'chapter' => '100.1',
),

array(
'id' => 13,
'question' => 'Hva st�r FS for ?',
'alternatives' => array('Formation Skydiving', 'Freestyle Skydiving', 'Freefall Skydiving'),
'answer' => array(0),
'chapter' => '100.1',
),

array(
'id' => 14,
'question' => 'Hva menes med MSL ?',
'alternatives' => array('H�yde over havet', 'H�yde over bakken', 'H�yden for skjerm�pning', 'Maksimumsh�yde for hopping'),
'answer' => array(0),
'chapter' => '100.1',
),

array(
'id' => 15,
'question' => 'Hva menes med NOTAM ?',
'alternatives' => array('Publikasjon utgitt av Avinor', 'Kansellert tandemhopp', 'Radioforbindelse mellom bakken og flyet',
			'Radioforbindelse mellom en f�rstegangshopper og instrukt�r'),
'answer' => array(0),
'chapter' => '100.1',
),

array(
'id' => 16,
'question' => 'Hva menes med VFS ?',
'alternatives' => array('Frittfall formasjonshopping', 'Frittfall formasjonshopping hvor kroppen er vertikalt orientert',
			'Formasjonshopping med fem personer', 'Formasjonsflyging under skjerm'),
'answer' => array(1),
'chapter' => '100.1',
),

array(
'id' => 17,
'question' => 'Hva er den formelle definisjonen p� et fallskjermhopp ?',
'alternatives' => array(
		'Alle planlagte utsprang fra luftfart�y i den hensikt � anvende fallskjerm under '.
			'hele eller deler av nedstigningen.',
		'Alle planlagte fallskjermhopp fra luftfart�y',
		'Alle planlagte fallskjermhopp i den hensikt � anvende fallskjerm under hele eller deler '.
			'av nedstigningen.',
		'Alle hopp med fallskjerm'),
'answer' => array(0),
'chapter' => '100.3',
),

array(
'id' => 18,
'question' => 'Hva menes med vannhopp ?',
'alternatives' => array(
		'Fallskjermhopp der det er planlagt � lande i vann dypere enn 1 meter.',
		'Et fallskjermhopp der man lander i vann, uavhengig om det var planlagt eller ikke',
		'Fallskjermhopp der man skal lande i sj�en',
		'Spesielle oppvisningshopp som innbefatter landing i vann',
),
'answer' => array(0),
'chapter' => '100.3.6',
),

array(
'id' => 19,
'question' => 'Hva regnes som et oksygenhopp ?',
'alternatives' => array(
	'Fallskjermhopp fra h�yder over 12 000 fot MSL',
	'Fallskjermhopp fra h�yder over 13 000 fot MSL',
	'Fallskjermhopp fra h�yder over 14 000 fot MSL',
	'Fallskjermhopp fra h�yder over 15 000 fot MSL',
	),
'answer' => array(3),
'chapter' => '100.3.8',
),

array(
'id' => 20,
'question' => 'Hvilke krav stilles til en utenlandsk hopper som vil hoppe i Norge ?',
'alternatives' => array(
		'M� ha norsk sertifikat utstedt av F/NLF',
		'M� ha utenlandsk sertifikat i henhold til FAI Sporting Code Section 5',
		'M� ha utenlandsk sertifikat i henhold til FAI Sporting Organization Section 5',
		'M� ha utenlandsk sertifikat godkjent av F/NLF',
	),
'answer' => array(1),
'chapter' => '100.4.2',
),

array(
'id' => 21,
'question' => 'Hva menes med en selvstendig hopper ?',
'alternatives' => array(	
		'En hopper med egne meninger',
		'En hopper med A-sertifikat eller h�yere',
		'En hopper med B-sertifikat eller h�yere',
		'En hopper med C-sertifikat eller h�yere'),
'answer' => array(1),
'chapter' => '100.5.2',
),

array(
'id' => 22,
'question' => 'Hva er �pningspunkt ?',
'alternatives' => array(
	'Den h�yden du har n�r skjermen �pnes',
	'Det punktet i terrenget flyet er over n�r du hopper ut',
	'Det punktet i terrenget du befinner deg over n�r du hopper ut av flyet',
	'Det punktet i terrenget du befinner deg over n�r skjermen �pnes',
	),
'answer' => array(3),
'chapter' => '100.9.2',
),

array(
'id' => 23,
'question' => 'I hvilken h�yde skal bakkevind m�les ?',
'alternatives' => array(
		'Mellom 3-7 meter over bakkeniv�',
		'Mellom 2-6 meter over bakkeniv�',
		'Mellom 1-5 meter over bakkeniv�',
		'Mellom 1-10 meter over bakkeniv�',
	),
'answer' => array(0),
'chapter' => '100.8.1',
),

array(
'id' => 24,
'question' => 'Hvordan m�les styrken til bakkevind ?',
'alternatives' => array(
		'Sterkeste vindkast i 3-7 meter over bakken i en 10-minutters periode',
		'Sterkeste vindkast i 2-10 meter over bakken i en 5-minutters periode',
		'Sterkeste vindkast i 2-10 meter over bakken i en 10-minutters periode',
		'Sterkeste vindkast i 3-7 meter over bakken i en 5-minutters periode',
	),
'answer' => array(0),
'chapter' => '100.8.1',
),

array(
'id' => 25,
'question' => 'I hvilken h�yde m�les middelvind ?',
'alternatives' => array(
		'Gjennomsnitlig vindhastighet opp til 500 fots h�yde',
		'Gjennomsnitlig vindhastighet opp til 1000 fots h�yde',
		'Gjennomsnitlig vindhastighet opp til 1500 fots h�yde',
		'Gjennomsnitlig vindhastighet opp til 2000 fots h�yde',
	),
'answer' => array(3),
'chapter' => '100.8.2',
),

array(
'id' => 26,
'question' => 'Hva menes med h�ydevind ?',
'alternatives' => array(
	'Vindhastighet over 1000 fot',
	'Vindhastighet over 2000 fot',
	'Vindhastighet over 3000 fot',
	'Vindhastighet over 4000 fot',
	),
'answer' => array(1),
'chapter' => '100.8.3',
),

array(
'id' => 27,
'question' => 'Hvilke m�leenheter brukes i fallskjermhopping ?',
'alternatives' => array(
	'H�yde: fot, distanse: meter, vindstyrke: knop',
	'H�yde: fot, distanse: meter, vindstyrke: meter/sekund',
	'H�yde: meter, distanse: fot, vindstyrke: meter/sekund',
	'H�yde: meter, distanse: fot, vindstyrke: knop ',
	),
'answer' => array(0),
'chapter' => array('100.10', '100.10.1', '100.10.2', '100.10.3'),
),

array(
'id' => 28,
'question' => 'Hva er maksimum alkoholpromille i blodet du kan hoppe med?',
'alternatives' => array(
	'100% edru',
	'0.2 promille',
	'0.4 promille',
	'0.6 promille',
	),
'answer' => array(1),
'chapter' => '102.3',
),

array(
'id' => 29,
'question' => 'Hvilken vingebelastning (wingload) gjelder for <i>f�rstegangshoppere</i> ?',
'alternatives' => array(
	'Maks 0.95 lb/sqft',
	'Maks 1.0 lb/sqft',
	'Maks 1.1 lb/sqft',
	'Maks 1.2 lb/sqft',
	),
'answer' => array(0),
'chapter' => '102.4.1.1',
),

array(
'id' => 30,
'question' => 'N�r man beregner vingebelastning (wingload), hvor mye vekt skal man legge til kroppsvekten (for utstyr og kl�r) ?',
'alternatives' => array(
	'15 kg for hopping med elevutstyr, 12 kg for hopping med sportsutstyr',
	'15 kg for hopping med elevutstyr og sportsutstyr',
	'12 kg for hopping med elevutstyr og sportsutstyr',
	'12 kg for hopping med elevutstyr, 15 kg for hopping med sportsutstyr',
	),
'answer' => array(0),
'chapter' => '102.4.1.1',
),

array(
'id' => 31,
'question' => 'Hvordan beregner man vingebelastning (wingload) ?',
'alternatives' => array(
	'lb/ft<sup>2</sup> &mdash; Exit-vekt i pund delt p� skjermens st�rrelse i kvadratfot',
	'kg/ft<sup>2</sup> &mdash; Exit-vekt i kilo delt p� skjermens st�rrelse i kvadratfot',
	'kg/m<sup>2</sup> &mdash; Exit-vekt i kilo delt p� skjermens st�rrelse i kvadratmeter',
	'lb/m<sup>2</sup> &mdash; Exit-vekt i pund delt p� skjermens st�rrelse i kvadratmeter',
	),
'answer' => array(0),
'chapter' => '102.4.1.1',
),

array(
'id' => 32,
'question' => 'Hvilke regler gjelder for bruk av hjelm ?',
'alternatives' => array(
	'Alle m� ha hjelm, elever m� ha hjelm med hardt skall',
	'Kun elever er p�krevd hjelm',
	'De over 200 hopp kan ha myk hjelm, andre m� ha hjelm med hardt skall',
	),
'answer' => array(0),
'chapter' => '102.4.2',
),

array(
'id' => 33,
'question' => 'Hvilken vingebelastning (wingload) gjelder for de mindre enn 200 hopp ?',
'alternatives' => array(
	'Maks 1.0 lb/sqft',
	'Maks 1.1 lb/sqft',
	'Maks 1.3 lb/sqft',
	'Maks 1.6 lb/sqft',
	),
'answer' => array(1),
'chapter' => '102.4.1.1',
),

array(
'id' => 34,
'question' => 'Hvilken vingebelastning (wingload) gjelder for de med mellom 200 og 350 hopp ?',
'alternatives' => array(
	'Maks 1.0 lb/sqft',
	'Maks 1.1 lb/sqft',
	'Maks 1.3 lb/sqft',
	'Maks 1.6 lb/sqft',
	),
'answer' => array(2),
'chapter' => '102.4.1.1',
),

array(
'id' => 35,
'question' => 'Hvilken vingebelastning (wingload) gjeldet for de med 350-500 hopp ?',
'alternatives' => array(
	'Maks 1.0 lb/sqft',
	'Maks 1.1 lb/sqft',
	'Maks 1.3 lb/sqft',
	'Maks 1.6 lb/sqft'
	),
'answer' => array(3),
'chapter' => '102.4.1.1',
),

array(
'id' => 36,
'question' => 'I hvilke situasjoner er ikke visuell h�ydem�ler p�krevd ?',
'alternatives' => array(
	'M� alltid ha visuell h�ydem�ler',
	'I formasjonshopping hvor en av de andre har visuell h�ydem�ler',
	'Ved bruk av akustisk h�ydem�ler',
	'For vannhopp med utsprang under 5000 fot',
	),
'answer' => array(3),
'chapter' => '102.4.6',
),

array(
'id' => 37,
'question' => 'For utsprangsh�yde <i>over</i> 2500 fot, i hvilken h�yde skal man henge i skjerm ?',
'alternatives' => array(
	'2000 fot AGL',
	'1500 fot AGL',
	'1800 fot AGL',
	'1750 fot AGL',
	),
'answer' => array(0),
'chapter' => array('102.5.1', '100.7.1'),
),

array(
'id' => 38,
'question' => 'For utsprangsh�yde under 2500 fot, hvilke regler gjelder ?',
'alternatives' => array(
	'Trekk innen 2 sek',
	'Trekk slik at man henger i skjerm i 1500 fot, 2 sek for lavere utsprangsh�yder enn dette',
	'Hvis flyet har en fart over 60 knop skal man trekke innen 4 sek',
	'Trekk slik at man henger i skjerm over den h�yden Cypres fyrer',
	),
'answer' => array(0),
'chapter' => '102.5.2',
),

array(
'id' => 39,
'question' => 'Hvilke regler gjelder for utsprangsh�yde for elever (ikke AFF) ?',
'alternatives' => array(
	'Laveste utsprangsh�yde 3500 fot, laveste trekkh�yde 3000 fot, laveste utsprangsh�yde for linehopp 3000 fot',
	'Laveste utsprangsh�yde 3500 fot, laveste trekkh�yde 3000 fot',
	'Laveste utsprangsh�yde 3500 fot, laveste trekkh�yde 2500 fot',
	'Laveste utsprangsh�yde 3500 fot, laveste trekkh�yde 2500 fot, laveste utsprangsh�yde for linehopp 3000 fot',
	),
'answer' => array(0),
'chapter' => '102.5.3',
),

array(
'id' => 40,
'question' => 'Hva er laveste tillatte utsprangsh�yde for AFF-elever (niv� 1-7) ?',
'alternatives' => array(
	'10000 fot',
	'9000 fot',
	'12000 fot',
	'13500 fot'),
'answer' => array(1),
'chapter' => '102.5.3',
),

array(
'id' => 41,
'question' => 'Hva er laveste utsprangsh�yde for selvstendige hoppere ?',
'alternatives' => array(
	'1500 fot hvis flyhastigheten er minst 60 knop, 1800 fot ellers',
	'1500 fot',
	'1800 fot',
	'1800 fot hvis flyhastigheten er st�rre enn 60 knop',
	),
'answer' => array(0),
'chapter' => '102.5.4',
),

array(
'id' => 42,
'question' => 'Hva er h�yeste utsprangsh�yde for alminnelige (ikke-oksygen) hopp ?',
'alternatives' => array(
	'Maks 15000 fot MSL',
	'Maks 13500 for MSL',
	'Maks 14000 fot MSL',
	'Maks 13000 fot MSL',
	),
'answer' => array(0),
'chapter' => '102.5.5',
),

array(
'id' => 43,
'question' => 'Hvilke regler gjelder for utsprangsh�yde for ikke-oksygenhopp ?',
'alternatives' => array(
	'Maks 15000 fot MSL, maks eksponeringstid 10 minutter mellom 13000 og 15000 fot MSL',
	'Maks 15000 fot MSL, maks eksponeringstid 10 minutter over 1400 fot MSL',
	'Maks 13500 fot MSL',
	'Maks 16000 fot MSL dersom eksponeringstiden er mindre enn 10 minutter over 13500 fot MSL',
	),
'answer' => array(0),
'chapter' => '102.5.5',
),

array(
'id' => 44,
'question' => 'Hvilke vindgrenser gjelder for bakkevind ?',
'alternatives' => array(
	'Maks 14 knop for elever, 18 knop for erfarne elever, 22 knop for selvstendige hoppere',
	'Maks 14 knop for elever, 25 knop for selvstendige hoppere',
	'Maks 21 knop',
	'Maks 18 knop for elever, 20 knop for erfarne elever, 22 knop for selvstendige hoppere',
	),
'answer' => array(0),
'chapter' => '102.6.1',
),

array(
'id' => 45,
'question' => 'Hva er h�yeste bakkevind for hoppere med rund reserve ?',
'alternatives' => array(
	'14 knop',
	'18 knop',
	'22 knop',
	'20 knop'),
'answer' => array(1),
'chapter' => '102.6.3',
),

array(
'id' => 46,
'question' => 'Hva er den korrekte spesifikasjonen p� en driver ?',
'alternatives' => array(
	'25 x 625 cm krepp-papirremse med 30 gram vekt i ene enden',
	'25 x 600 cm krepp-papirremse med 30 gram vekt i ene enden',
	'25 x 625 cm krepp-papirremse med 32.5 gram vekt i ene enden',
	'Gul papirremse p� ca 6 meter, to sm� �ser med sand som vekt',
	),
'answer' => array(0),
'chapter' => '102.7.1',
),

array(
'id' => 47,
'question' => 'Hvor stort skal et hoppfelt v�re ?',
'alternatives' => array(
	'Diameter p� minst 200 meter',
	'Diameter p� minst 250 meter',
	'Diameter p� minst 500 meter',
	'Diameter p� minst 750 meter'),
'answer' => array(0),
'chapter' => '102.8.1',
),

array(
'id' => 48,
'question' => 'Redningsvest m� benyttes av <i>elever, A-sertifikat og de med rundreserve</i> dersom det finnes vann dypere enn 1 meter innen:',
'alternatives' => array(
	'1000 meter',
	'500 meter',
	'250 meter',
	'200 meter'),
'answer' => array(0),
'chapter' => '102.8.3.1',
),

array(
'id' => 49,
'question' => 'Redningsvest m� benyttes av de med <i>B- til og med D-sertifikat</i> dersom det finnes vann dypere enn 1 meter innen:',
'alternatives' => array(
	'250 meter',
	'500 meter',
	'750 meter',
	'1000 meter'),
'answer' => array(0),
'chapter' => '102.8.3.2',
),

array(
'id' => 50,
'question' => 'Hva betyr det n�r jordtegnet (T-en) er lagt ut som en I (en linje) ?',
'alternatives' => array(
	'Midlertidig hoppforbud',
	'Hoppforbud',
	'Noen har glemt � legge ut T-en',
	'Flyet m� lande'),
'answer' => array(0),
'chapter' => '102.9.1',
),

array(
'id' => 51,
'question' => 'Hva betyr det n�r jordtegnet er tatt inn ?',
'alternatives' => array(
	'Midlertidig hoppforbud',
	'Ingen betydning',
	'Hoppforbud',
	'Noen har glemt � legge ut T-en',
	),
'answer' => array(2),
'chapter' => '102.9.1',
),

array(
'id' => 52,
'question' => 'Under hvilken h�yde skal hoppere i FS/VFS ikke lenger ha kontakt ?',
'alternatives' => array(
	'3500 fot',
	'3000 fot',
	'2500 fot',
	'2200 fot',
	),
'answer' => array(0),
'chapter' => '102.11.1',
),

array(
'id' => 53,
'question' => 'Hvor lenge varer en wave-off (eller, hva st�r i H�ndboka, 8. utgave fra Mai 2003, og kanskje ikke i div fasiter) ?',
'alternatives' => array(
	'1-2 sek',
	'2-3 sek',
	'3-4 sek',
	'1-4 sek',
	),
'answer' => array(1),
'chapter' => '102.11.2',
),

array(
'id' => 54,
'question' => 'Hvem har vikeplikt i FS/VFS ?',
'alternatives' => array(
	'Den hopperen som er �verst har vikeplikt for de under',
	'Den hopperen som er nederst har vikeplikt for de over',
	'Den hopperen med lavest erfaringsniv� har vikeplikt',
	'Den hopperen med h�yeste erfaringsniv� har vikeplikt',
	),
'answer' => array(0),
'chapter' => '102.11.2',
),

array(
'id' => 55,
'question' => 'Hva er minste h�yde man kan oppn� kontakt (docking) i kalott formasjonshopping (CF) med <i>to hoppere</i> ?',
'alternatives' => array(
	'1000 fot',
	'1500 fot',
	'2000 fot',
	'2500 fot',
	),
'answer' => array(1),
'chapter' => '102.12.1',
),

array(
'id' => 56,
'question' => 'Hva er minste h�yde man kan oppn� kontakt (docking) i kalott formasjonshopping (CF) med <i>flere enn to</i> hoppere ?',
'alternatives' => array(
	'1000 fot',
	'1500 fot',
	'2000 fot',
	'2500 fot'
	),
'answer' => array(3),
'chapter' => '102.12.1',
),

array(
'id' => 57,
'question' => 'Hvilket minste sertifikat kreves for � utf�re natthopp ?',
'alternatives' => array(
	'A',
	'B',
	'C',
	'D',
	),
'answer' => array(2),
'chapter' => '103.2.4',
),

array(
'id' => 58,
'question' => 'Hvilket minste sertifikat kreves for � utf�re vannhopp ?',
'alternatives' => array(
	'A',
	'B',
	'C',
	'D',
	),
'answer' => array(1),
'chapter' => '103.3.4',
),

array(
'id' => 59,
'question' => 'Ved oppvisningshopp, hva er minste avstand mellom landingsomr�de og publikum ?',
'alternatives' => array(
	'15 meter horisontalt, 25 fot vertikalt',
	'20 meter horisontalt, 25 fot vertikalt',
	'20 meter horisontalt, 33 fot vertikalt',
	'15 meter horisontalt, 33 fot vertikalt',
	),
'answer' => array(0),
'chapter' => '103.4.5',
),

array(
'id' => 60,
'question' => 'Hvilken utsprangs- og trekkh�yde gjelder for tandemhopp?',
'alternatives' => array(
	'Laveste utsprangsh�yde 5000 fot, laveste trekkh�yde 3500 fot',
	'Laveste utsprangsh�yde 7500 fot, laveste trekkh�yde 5000 fot',
	'Laveste utsprangsh�yde 10000 fot, laveste trekkh�yde 5000 fot',
	'Laveste utsprangsh�yde 13500 fot, laveste trekkh�yde 3500 fot',
	),
'answer' => array(1),
'chapter' => '103.5.4',
),

array(
'id' => 61,
'question' => 'Hvem har rett og plikt til � gripe inn p� brudd av materiellreglementets bestemmelser ?',
'alternatives' => array(
	'HL',
	'HI',
	'Ethvert medlem av F/NLF',
	'Instrukt�rer',
	),
'answer' => array(2),
'chapter' => '201.4.1',
),

array(
'id' => 62,
'question' => 'Hvem er ansvarlig (materiellforvalter) for fallskjermutstyret ditt ?',
'alternatives' => array(
	'Du som eier er selv materiellforvalter for fallskjermutstyret ditt',
	'Klubbens MK',
	'Klubbens HI',
	'Klubbstyret',
	),
'answer' => array(0),
'chapter' => '202.7',
),

array(
'id' => 63,
'question' => '�pen ild skal ikke forekomme innen:',
'alternatives' => array(
	'10 meter fra fallskjermmateriell',
	'15 meter fra fallskjermmateriell',
	'25 meter fra fallskjermmateriell',
	'50 meter fra fallskjermmateriell',
	),
'answer' => array(3),
'chapter' => '206',
),

array(
'id' => 64,
'question' => 'Hvor lenge kan en reserveskjerm ligge lagret i pakket tilstand f�r den er ikke er luftdyktig ?',
'alternatives' => array(
	'6 m�neder for elevutstyr, 12 m�neder for privateid sportsutstyr',
	'3 m�neder for elevutstyr, 6 m�neder for privateid sportsutstyr',
	'3 m�neder for elevutstyr, 12 m�neder for privateid sportsutstyr',
	'6 m�neder for elevutstyr, 6 m�neder for privateid sportsutstyr',
	),
'answer' => array(0),
'chapter' => '206.1',
),

array(
'id' => 65,
'question' => 'Hvor mange pakkekontroller skal foretas for vingskjermer',
'alternatives' => array(
	'5',
	'4',
	'3',
	'2',
	),
'answer' => array(1),
'chapter' => '206.2.1',
),

array(
'id' => 66,
'question' => 'Hva plikter du deg som medlem av F/NLF � gj�re i forhold til rusmiddel og dopingtester ?',
'alternatives' => array(
	'Du skal til enhver tid underkaste deg doping- eller rusmiddelkontroll, herunder utvidet blodpr�ve',
	'Du plikter deg kun til � underkaste deg dopingkontroll',
	'F/NLF kan ikke kreve doping- eller rusmiddelkontroll',
	'Du plikter deg kun til � underkaste deg blodpr�ve',
	),
'answer' => array(0),
'chapter' => '301.1',
),

array(
'id' => 67,
'question' => 'Hvem kan attestere s�knad om <i>utstedelse</i> av elevbevis, fallskjermsertifikat eller lisens ?',
'alternatives' => array(
	'Instrukt�r 1',
	'Instrukt�r 2 eller h�yere',
	'Instrukt�r 3 eller h�yere',
	'D-sertifikat eller h�yere',
	),
'answer' => array(0),
'chapter' => '301.1',
),

array(
'id' => 68,
'question' => 'Hvem kan attestere s�knad om <i>fornyelse</i> av elevbevis, fallskjermsertifikat eller lisens ?',
'alternatives' => array(
	'Instrukt�r 1 eller h�yere',
	'Instrukt�r 2 eller h�yere',
	'Instrukt�r 3 eller h�yere',
	'D-sertifikat eller h�yere',
	),
'answer' => array(1),
'chapter' => '301.1',
),

array(
'id' => 69,
'question' => 'Hvor mange m�neder etter siste hovedkontroll skal <i>elevfallskjermsett</i> underlegges ny hovedkontroll ?',
'alternatives' => array(
	'Innen 6 m�neder etter siste hovedkontroll',
	'Innen 3 m�neder etter siste hovedkontroll',
	'Innen 12 m�neder etter siste hovedkontroll',
	'Innen 100 dager etter siste hovedkontroll',
	),
'answer' => array(0),
'chapter' => '207.1.2',
),

array(
'id' => 70,
'question' => 'Hvor mange m�neder etter siste hovedkontroll skal <i>privateid</i> fallskjermsett underlegges ny hovedkontroll ?',
'alternatives' => array(
	'Innen 6 m�neder etter siste hovedkontroll',
	'Innen 3 m�neder etter siste hovedkontroll',
	'Innen 12 m�neder etter siste hovedkontroll',
	'Innen 100 dager etter siste hovedkontroll',
	),
'answer' => array(2),
'chapter' => '207.1.2',
),

array(
'id' => 71,
'question' => 'Hvor mange m�neder etter hovedkontroll er elevfallskjermsett luftdyktig f�r det m� underlegges brukskontroll ?',
'alternatives' => array(
	'3 m�neder',
	'6 m�neder',
	'7 m�neder',
	'12 m�neder',
	),
'answer' => array(0),
'chapter' => '207.1.2',
),

array(
'id' => 72,
'question' => 'Hvor ofte m� du underlegge ditt privateide sportsutstyr for hovedkontroll ?',
'alternatives' => array(
	'Hver 6. m�ned',
	'Hver 12. m�ned',
	'Hver 9. m�ned',
	'F�r nytt utstyr tas i bruk, ellers etter behov',
	),
'answer' => array(1),
'chapter' => '207.1.2',
),

array(
'id' => 73,
'question' => 'Hvilke kassasjonsregler gjelder for fallskjermkomponenter som har v�rt i kontakt med saltvann ?',
'alternatives' => array(
	'M� kasseres dersom utstyret har v�rt i kontakt med saltvann i mer enn 48 timer, eller ikke blitt'.
		' tilfredstillende skyllet innen 24 timer etter berging',
	'M� kasseres dersom utstyret har v�rt i kontakt med saltvann i mer enn 24 timer, eller ikke blitt'.
		' tilfredstillende skyllet innen 12 timer etter berging',
	'M� kasseres dersom utstyret har v�rt i kontakt med saltvann i mer enn 24 timer',
	'M� kasseres dersom utstyret har v�rt i kontakt med saltvann i mer enn 12 timer, eller ikke blitt'.
		' tilfredstillende skyllet innen 24 timer etter berging',
	),
'answer' => array(0),
'chapter' => '208.2.3.2',
),

array(
'id' => 74,
'question' => 'Hva betyr det n�r det er malt en diagonal strek over pakksekken og serienummeret ?',
'alternatives' => array(
	'Utstyret er kassert og skal ikke benyttes',
	'Utstyret skal inn til hovedkontroll',
	'Utstyret skal inn til brukskontroll',
	'Utstyret har v�rt i kontakt med saltvann',
	),
'answer' => array(0),
'chapter' => '208.2.4',
),

array(
'id' => 75,
'question' => 'Hva er maksimum synkehastighet for rund reserveskjerm ?',
'alternatives' => array(
	'Maks 7.5 m/sek ved en belastning p� 75 kg',
	'Maks 15 m/sek ved en belastning p� 75 kg',
	'Maks 7.5 m/sek ved en belastning p� 100 kg',
	'Maks 15 m/sek ved en belastning p� 100 kg',
	),
'answer' => array(0),
'chapter' => '208.5',
),

array(
'id' => 76,
'question' => 'Hvilke spesifikasjoner gjelder for en utl�serlines bruddstyrke og lengde ?',
'alternatives' => array(
	'1000 kg, 3.90 meter',
	'750 kg, 3.90 meter',
	'1000 kg, 4.90 meter',
	'750 kg, 4.90 meter',
	),
'answer' => array(0),
'chapter' => '209.1',
),

array(
'id' => 77,
'question' => 'Hva er minimum oppdrift en flytevest m� ha for � kunne anvendes i forbindelse med hopping ?',
'alternatives' => array(
	'50 Newton',
	'75 Newton',
	'93 Netwon',
	'100 Newton',
	),
'answer' => array(0),
'chapter' => '213.2',
),

array(
'id' => 78,
'question' => 'Hvem m� bevitne postlegging av sertifikat for at det skal v�re umiddelbart gyldig ?',
'alternatives' => array(
	'Instrukt�r 1',
	'Instrukt�r 2',
	'Instrukt�r 3',
	'Hovedinstrukt�r',
	),
'answer' => array(1),
'chapter' => '301.2',
),

array(
'id' => 79,
'question' => 'Kan instrukt�rer fornye egne sertifikat ?',
'alternatives' => array(
	'Ja',
	'Nei',
	'Kanskje',
	'Vet ikke',
	),
'answer' => array(1),
'chapter' => '301.5',
),

array(
'id' => 80,
'question' => 'Hvor mange frittfallhopp kreves for � f� tatt A-sertifikat med bakgrunn i <i>grunnkurs, line</i> ?',
'alternatives' => array(
	'10',
	'20',
	'25',
	'30',
	),
'answer' => array(1),
'chapter' => '308.1.1',
),

array(
'id' => 81,
'question' => 'Hvilke regler gjelder for deltakelse i FS/VFS for en person med A-sertifikat ?',
'alternatives' => array(
	'Under praktisk oppl�ring av instrukt�r, ikke mer enn totalt 3 hoppere i formasjon',
	'Ikke mer enn totalt 4 hoppere i formasjon',
	'Under praktisk oppl�ring av instrukt�r, ikke mer enn totalt 4 hoppere i formasjon',
	'Under praktisk oppl�ring av instrukt�r, ikke mer enn totalt 2 hoppere i formasjon',
	),
'answer' => array(0),
'chapter' => '308.2',
),

array(
'id' => 82,
'question' => 'Hvilke fornyelseskrav gjelder for A-sertifikat ?',
'alternatives' => array(
	'Minimum 20 hopp siste 365 dager',
	'Minimum 15 hopp siste 365 dager',
	'Minimum 10 hopp siste 365 dager',
	'Minimum 5 hopp siste 365 dager',
	),
'answer' => array(0),
'chapter' => '308.3.1',
),

array(
'id' => 83,
'question' => 'Hvor mange hopp kreves for � f� B-sertifikat ?',
'alternatives' => array(
	'Minst 50 godkjente frittfallhopp',
	'Minst 25 godkjente frittfallhopp',
	'Minst 30 godkjente frittfallhopp',
	'Minst 60 godkjente frittfallhopp',
	),
'answer' => array(0),
'chapter' => '309.1',
),

array(
'id' => 84,
'question' => 'Hvor mye akkumulert frittfalltid kreves for � f� B-sertifikat ?',
'alternatives' => array(
	'30 minutt',
	'20 minutt',
	'10 minutt',
	'40 minutt',
	),
'answer' => array(0),
'chapter' => '309.1',
),

array(
'id' => 85,
'question' => 'Hvor mange godkjente frittfallhopp kreves for � f� C-serrtifikat ?',
'alternatives' => array(
	'200',
	'150',
	'250',
	'125',
	),
'answer' => array(0),
'chapter' => '310.1',
),

array(
'id' => 86,
'question' => 'Hvor mange formasjonshopp (FS og/eller VFS) kreves for � f� C-sertifikat ?',
'alternatives' => array(
	'50',
	'30',
	'40',
	'60',
	),
'answer' => array(0),
'chapter' => '310.1',
),

array(
'id' => 87,
'question' => 'Hvor mye akkumulert frittfalltid kreves for � f� C-sertifikat ?',
'alternatives' => array(
	'Mer enn 60 minutter',
	'Mer enn 120 minutter',
	'Mer enn 90 minutter',
	'Mer enn 85 minutter',
	),
'answer' => array(0),
'chapter' => '310.1',
),

array(
'id' => 88,
'question' => 'Hvilke fornyelseskrav gjelder for C-sertifikat ?',
'alternatives' => array(
	'Minimum 40 hopp siste 365 dager',
	'Minimum 50 hopp siste 365 dager',
	'Minimum 60 hopp siste 365 dager',
	'Minimum 30 hopp siste 365 dager',
	),
'answer' => array(0),
'chapter' => '310.3',
),

array(
'id' => 89,
'question' => 'Hvilke fornyelseskrav gjelder for B-sertifikat ?',
'alternatives' => array(
	'Minimum 20 hopp siste 365 dager',
	'Minimum 15 hopp siste 365 dager',
	'Minimum 10 hopp siste 365 dager',
	'Minimum 5 hopp siste 365 dager',
	),
'answer' => array(0),
'chapter' => array('309.3', '308.3.1'),
),

array(
'id' => 90,
'question' => 'Hvor mange frittfallhopp kreves for � f� D-sertifikat ?',
'alternatives' => array(
	'500',
	'350',
	'300',
	'600',
	),
'answer' => array(0),
'chapter' => '311.1',
),

array(
'id' => 91,
'question' => 'Hvor mange timer akkumulert frittfalltid kreves for � f� D-sertifikat ?',
'alternatives' => array(
	'3 timer',
	'2 timer',
	'4 timer',
	'5 timer',
	),
'answer' => array(0),
'chapter' => '311.1',
),

array(
'id' => 910, /* already made id 91 */
'question' => 'Hvilke sertifikater og lisenser kreves for � f� D-sertifikat ?',
'alternatives' => array(
	'Inneha C-sertifikat og Instrukt�r 3-lisens',
	'Inneha C-sertifikat og Instrukt�r 2-lisens',
	'Inneha C-sertifikat',
	'Inneha C-sertifikat eller Instrukt�r 3-lisens',
	),
'answer' => array(0),
'chapter' => '311.1',
),

array(
'id' => 92,
'question' => 'Hvilket sertifikat kreves for � godkjenne hoppfelt for egen hopping ?',
'alternatives' => array(
	'A-sertifikat',
	'B-sertifikat',
	'C-sertifikat',
	'D-sertifikat',
	),
'answer' => array(3),
'chapter' => '311.2',
),

// todo: hvis du har C-sert kan du v�re HL n�r elever er til stede
array(
'id' => 93,
'question' => 'Hvilket sertifikat kreves for � fungere som hoppleder (HL) ved alminnelig hopping ?',
'alternatives' => array(
	'A-sertifikat',
	'B-sertifikat',
	'C-sertifikat',
	'D-sertifikat',
	),
'answer' => array(3),
'chapter' => '311.2',
),

array(
'id' => 94,
'question' => 'Hvilke kvalifikasjonskrav gjelder for de som vil ta videosertifikat tandem ?',
'alternatives' => array(
	'C-sertifikat, minimum 50 hopp som fotograf for FS',
	'D-sertifikat, minimum 50 hopp som fotograf for FS',
	'D-sertifikat, minimum 40 hopp som fotograf for FS',
	'C-sertifikat, minimum 40 hopp som fotograf for FS',
	),
'answer' => array(0),
'chapter' => '313.1.2',
),

array(
'id' => 95,
'question' => 'Hvilke kvalifikasjonskrav under gjelder for � f� Demosertifikat II ?',
'alternatives' => array(
	'C-sertifikat, minimum 300 hopp',
	'D-sertifikat, minimum 300 hopp',
	'D-sertifikat, minimum 500 hopp',
	'C-sertifikat, minimum 200 hopp',
	),
'answer' => array(0),
'chapter' => '314.1.1',
),

array(
'id' => 96,
'question' => 'Hvilke kvalifikasjonskrav under gjelder for � f� Demosertifikat I ?',
'alternatives' => array(
	'D-sertifikat, Demosertifikat II, deltatt i minst 10 oppvisningshopp',
	'D-sertifikat, deltatt i minst 10 oppvisningshopp',
	'C-sertifikat, Demosertifikat II, deltatt i minst 10 oppvisningshopp',
	'D-sertifikat, Demosertifikat II, deltatt i minst 20 oppvisningshopp',
	),
'answer' => array(0),
'chapter' => '314.2.1',
),

array(
'id' => 97,
'question' => 'Hvilket sertifikat kreves for lede en fallskjermoppvisning ?',
'alternatives' => array(
	'Demosertifikat I',
	'Demosertifikat II',
	'D-sertifikat og Demosertifikat II',
	'C- eller D-sertifikat',
	),
'answer' => array(0),
'chapter' => '314.2.2',
),

array(
'id' => 98,
'question' => 'Hvilket vedlikeholdskrav gjelder for Demosertifikat I ?',
'alternatives' => array(
	'Inneha gyldig D-sertifikat',
	'Minst 2 oppvisningshopp siste 365 dager',
	'Inneha D-sertifikat, minst 2 oppvisningshopp siste 365 dager',
	'Hatt minst 50 hopp siste �r, hvordan minst 10 er FS/VFS',
	),
'answer' => array(0),
'chapter' => '314.2.4',
),

array(
'id' => 99,
'question' => 'Hvilke kvalifikasjoner gjelder for � f� Demosertifikat Tandem ?',
'alternatives' => array(
	'Ha Demosertifikat I, tandeminstrukt�r i 1 �r, minst 200 tandemhopp',
	'Ha Demosertifikat II, tandeminstrukt�r i 1 �r, minst 200 tandemhopp',
	'Ha Demosertifikat I, minst 200 tandemhopp',
	'Ha Demosertifikat I, tandeminstrukt�r i 1 �r, minst 100 tandemhopp',
	),
'answer' => array(0),
'chapter' => '314.3.1',
),

array(
'id' => 100,
'question' => 'Hvem skal lede oppvisning der tandemhopp inng�r som en del av oppvisningen ?',
'alternatives' => array(
	'Demosertifikat Tandem',
	'Demosertifikat I',
	'Demosertifikat II',
	'Instrukt�r 1',
	),
'answer' => array(0),
'chapter' => '314.3.2',
),

array(
'id' => 101,
'question' => 'Hvilke vedlikeholdskrav gjelder for Demosertifikat Tandem ?',
'alternatives' => array(
	'Gyldig D-sertifikat, gyldig demosertifikat klasse I, minst 50 tandemhopp siste 365 dager',
	'Gyldig D-sertifikat, gyldig demosertifikat klasse I',
	'Gyldig D-sertifikat, gyldig demosertifikat klasse I, minst 25 tandemhopp siste 365 dager',
	'Gyldig D-sertifikat, minst 60 tandemhopp siste 365 dager',
	),
'answer' => array(0),
'chapter' => '314.3.4',
),

array(
'id' => 102,
'question' => 'Hvem er det som vurderer og tar ut instrukt�rkandidater av klasse 3 ?',
'alternatives' => array(
	'Lokalklubbens Hovedinstrukt�r',
	'Sikkerhets- og utdanningskomiteen F/NLF',
	),
'answer' => array(0),
'chapter' => '401.2',
),

array(
'id' => 103,
'question' => 'Hvem er det som vurderer og tar ut instrukt�rkandidater av klasse 2 eller h�yere ?',
'alternatives' => array(
	'Lokalklubbens Hovedinstrukt�r',
	'Sikkerhets- og utdanningskomiteen F/NLF',
	),
'answer' => array(1),
'chapter' => '401.2',
),

array(
'id' => 104,
'question' => 'Hvilke fornyelseskrav gjelder for Instrukt�r/Eksaminator ?',
'alternatives' => array(
	'Ingen',
	'Foretatt minst 2 eksaminasjoner siste 365 dager',
	'Inne ha gyldig instrukt�rsertifikat av gjeldende klasse',
	),
'answer' => array(0),
'chapter' => '401.5.2',
),

array(
'id' => 105,
'question' => 'Hvilken instrukt�rklasse kreves minimum for � kunne hoppmestre lineelever ?',
'alternatives' => array(
	'Instrukt�r 1',
	'Instrukt�r 2',
	'Instrukt�r 3',
	),
'answer' => array(2),
'chapter' => '402.1',
),

array(
'id' => 106,
'question' => 'Hvilken instrukt�rklasse kreves minimum for � kunne hoppmestre elever p� frittfall ?',
'alternatives' => array(
	'Instrukt�r 1',
	'Instrukt�r 2',
	'Instrukt�r 3',
	),
'answer' => array(2),
'chapter' => '402.1',
),

array(
'id' => 107,
'question' => 'Hvilken instrukt�rklasse kreves minimum for � kunne attestere for progresjonshopp for line-elever ?',
'alternatives' => array(
	'Instrukt�r 1',
	'Instrukt�r 2',
	'Instrukt�r 3',
	),
'answer' => array(2),
'chapter' => '402.1.1',
),

array(
'id' => 108,
'question' => 'Hva slags erfaringskrav kreves for � kunne bli Instrukt�r 3 ?',
'alternatives' => array(
	'C-sertifikat, 5 ganger HFL med elever, hjelpeinstrukt�r p� 3 GK-1 og 2 GK-2',
	'C-sertifikat, 5 ganger HFL med elever',
	'D-sertifikat',
	'C-sertifikat',
	),
'answer' => array(0),
'chapter' => '402.1.1',
),

array(
'id' => 109,
'question' => 'Hva kreves minimum for � kunne <i>hoppmestre</i> hoppere p� natthopp ?',
'alternatives' => array(
	'D-sertifikat hvis innehaver har utf�rt natthopp tidligere',
	'Instrukt�r 3',
	'Instrukt�r 2',
	'Instrukt�r 1',
	),
'answer' => array(0),
'chapter' => '508.2',
),

array(
'id' => 110,
'question' => 'Hva kreves <i>minimum</i> for � kunne <i>hoppmestre</i> hoppere p� natthopp ?',
'alternatives' => array(
	'D-sertifikat, hvis du har hoppet natthopp f�r',
	'Kun Instrukt�r 3 eller h�yere',
	'Kun Instrukt�r 2 eller h�yere',
	'Kun Instrukt�r 1',
	),
'answer' => array(0),
'chapter' => '508.2',
),

array(
'id' => 111,
'question' => 'Hvilke av alternativene under gjelder som erfaringskrav til � bli Instrukt�r 2 ?',
'alternatives' => array(
	'Deltatt i 2 �rs praktisk hoppvirksomhet, herav minst 12 m�neder som I-3',
	'Deltatt i 1 �rs praktisk hoppvirksomhet, herav minst 12 m�neder som I-3',
	'Deltatt i 1 �rs praktisk hoppvirksomhet, herav minst 6 m�neder som I-3',
	'Deltatt i 2 �rs praktisk hoppvirksomhet, herav minst 6 m�neder som I-3',
	),
'answer' => array(0),
'chapter' => '402.2.1',
),

array(
'id' => 112,
'question' => 'Hvilke av alternativene under gjelder som erfaringskrav til � bli Instrukt�r 1 ?',
'alternatives' => array(
	'Deltatt i minst 3 �rs hoppvirksomhet, herav minst 12 m�neder som I-2',
	'Deltatt i minst 2 �rs hoppvirksomhet, herav minst 12 m�neder som I-2',
	'Deltatt i minst 3 �rs hoppvirksomhet, herav minst 6 m�neder som I-2',
	'Deltatt i minst 2 �rs hoppvirksomhet, herav minst 6 m�neder som I-2',
	),
'answer' => array(0),
'chapter' => '402.3.1',
),

array(
'id' => 113,
'question' => 'Hva kreves minst for � v�re hoppmester (HM) ved natthopping ?',
'alternatives' => array(
	'D-sertifikat som har gjort natthopp f�r, eller Instrukt�r 2 og opp',
	'Instrukt�r 2 eller h�yere',
	'Kun Instrukt�r 1',
	'Instrukt�r 3 eller h�yere',
	),
'answer' => array(0),
'chapter' => '508.2',
),

array(
'id' => 114,
'question' => 'Du er hoppmester (HM) p� et l�ft.  N�r du �pner d�ra ser du at T-en (jordtegnet) er tatt inn.  Hva skal du gj�re ?',
'alternatives' => array(
	'Spotte som vanlig',
	'Avbryte utsprang',
	'Be flygeren om � sirkle rundt helt til noen legger ut T-en igjen',
	'Hoppe ut og h�pe p� det beste',
	),
'answer' => array(1),
'chapter' => '508.3',
),

array(
'id' => 115,
'question' => 'Du er hoppmester (HM) p� et l�ft.  N�r du �pner d�ra ser du at T-en (jordtegnet) er lagt ut som en I (en strek).  Hva skal du gj�re ?',
'alternatives' => array(
	'Spotte som vanlig',
	'Be flygeren om � sirkle rundt helt til noen legget ut jordtegnet som en T igjen',
	'Be flygeren om � lande',
	'Fortelle en vits',
	),
'answer' => array(1),
'chapter' => array('508.3', '102.9.1'),
),

array(
'id' => 116,
'question' => 'Hva kreves av alternativene under for � bli Instrukt�r Tandem ?',
'alternatives' => array(
	'I-2 eller h�yere, minimum 100 hopp siste �r, D-sertifikat',
	'I-3 eller h�yere, minimum 100 hopp siste �r, D-sertifikat',
	'I-3 eller h�yere, minimum 200 hopp siste �r, D-sertifikat',
	'I-2 eller h�yere, minimum 200 hopp siste �r, D-sertifikat',
	),
'answer' => array(0),
'chapter' => '402.4.1',
),

array(
'id' => 117,
'question' => 'Hvilket sertifikat kreves minimum for � kunne v�re hoppleder (HL) for elever ?',
'alternatives' => array(
	'Instrukt�r 3',
	'B',
	'C',
	'D',
	),
'answer' => array(3),
'chapter' => '311.2',
),

array(
'id' => 118,
'question' => 'Hvilket sertifikat kreves minimum for � kunne v�re hoppleder (HL) for hoppere med A-sertifikat og oppover ?',
'alternatives' => array(
	'A',
	'B',
	'C',
	'D',
	),
'answer' => array(2),
'chapter' => '310.2',
),

array(
'id' => 119,
'question' => 'Hvem har rett og plikt til � gripe inn ved brudd p� operative bestemmelser ?',
'alternatives' => array(
	'Ethvert klubbmedlem',
	'D-sertifikat',
	'Instrukt�rer',
	'Hovedinstrukt�r',
	),
'answer' => array(0),
'chapter' => '501',
),

array(
'id' => 120,
'question' => 'Hvem typegodkjenner fallskjermmateriell ?',
'alternatives' => array(
	'Materiellsjefen (MSJ)',
	'Materiellkontroll�r (MK)',
	'Hovedinstrukt�r (HI)',
	'Hoppleder (HL)',
	),
'answer' => array(0),
'chapter' => '502.2',
),

array(
'id' => 121,
'question' => 'Hvilket sertifikatkrav gjelder normalt sett for Hovedinstrukt�r (HI) ved Operasjonstillatelse 1 (OT-1) ?',
'alternatives' => array(
	'Instrukt�r 1',
	'Instrukt�r 2',
	'Instrukt�r 3',
	'D-sertifikat',
	),
'answer' => array(0),
'chapter' => '502.3',
),

array(
'id' => 122,
'question' => 'Hvilket sertifikatniv� m� du minimum ha for � hoppe p� hoppfelt med Operasjonstillatelse 2 (OT 2) ?',
'alternatives' => array(
	'Elev p� frittfall',
	'A-sertifikat',
	'B-sertifikat',
	'C-sertifikat',
	'Kan hoppe som lineelev dersom HI godkjenner dette',
	),
'answer' => array(1),
'chapter' => '503.2',
),

array(
'id' => 123,
'question' => 'Du er p� et hoppfelt som ligger 3000 fot over havet, og nullstiller h�ydem�leren din her. '.
		'Hva vil h�ydem�leren din vise p� aller h�yeste h�yde som <i>ikke</i> regnes som oksygenhopp ?',
'alternatives' => array(
	'12000 fot',
	'10000 fot',
	'15000 fot',
	'13000 fot',
	),
'answer' => array(0),
'chapter' => '100.3.8',
),

array(
'id' => 124,
'question' => 'Hvem har som oppgave � underrette forulykkedes p�r�rende ved ulykker ?',
'alternatives' => array(
	'Hovedinstrukt�r',
	'Politiet',
	'Hoppleder',
	'Hoppfeltleder',
	),
'answer' => array(1),
'chapter' => '505.1',
),

array(
'id' => 125,
'question' => 'Hvem kan oppgi navn eller andre personalia til presse/media ved ulykker ?',
'alternatives' => array(
	'Hovedinstrukt�r',
	'Politiet',
	'Hoppleder',
	'Ethvert klubbmedlem i F/NLF',
	),
'answer' => array(1),
'chapter' => '505.2',
),

array(
'id' => 126,
'question' => 'Ved ulykker, hvordan b�r en oppf�re seg i forhold til s�rlig p�g�ende pressefolk ?',
'alternatives' => array(
	'V�r vennlig og svar p� alle sp�rsm�l som pressefolk m�tte ha',
	'Henvis til <i>v�r varsom</i>-paragrafen som er trykket p� deres eget pressekort',
	),
'answer' => array(1),
'chapter' => '505.2',
),

array(
'id' => 127,
'question' => 'Du er selvstendig hopper, i et fly i 1800 fots h�yde med en fart mindre enn 60 knop.  Hvor fort skal du trekke ?',
'alternatives' => array(
	'Innen 2 sekunder fra utsprang',
	'Innen 1 sekund fra utsprang',
	'Trekk f�r 1500 fot',
	'Innen 3 sekunder fra utsprang',
	),
'answer' => array(0),
'chapter' => '102.5.2',
),

array(
'id' => 128,
'question' => 'Du er i et fly som flyr raskere enn 60 knop.  Hvilke regler gjelder under for selvstendige hoppere ?',
'alternatives' => array(
	'Trekk innen 2 sekund hvis utsprangsh�yde er 1500 fot',
	'Trekk innen 3 sekund hvis utsprangsh�yde er 1800 fot',
	'Trekk innen 4 sekund hvis utsprangsh�yde er 1500 fot',
	'Trekk umiddelbart hvis utsprangsh�yde er 1500 fot',
	),
'answer' => array(0),
'chapter' => array('102.5.2', '102.5.4'),
),

array(
'id' => 129,
'question' => 'Kan HL delta i hopping ?',
'alternatives' => array(
	'Nei, HL m� v�re p� bakken og ha kontroll over hoppingen',
	'Ja, s� lenge det gj�res p� en slik m�te at HL til enhver tid har kontroll over virksomheten'
	),
'answer' => array(1),
'chapter' => '506.6.2',
),

array(
'id' => 130,
'question' => 'Hvem kan v�re hoppleder (HL) p� natt-, vann- og oksygenhopp dersom hopperne har utf�rt slike hopp f�r ?',
'alternatives' => array(
	'D-sertifikat eller Instrukt�r 2',
	'Instrukt�r 3',
	'Instrukt�r 1',
	'C-sertifikat eller Instrukt�r 3',
	),
'answer' => array(0),
'chapter' => '506.2',
),

array(
'id' => 131,
'question' => 'Hvem kan v�re hoppleder (HL) p� natt-, vann- og oksygenhopp dersom hopperne <i>ikke</i> har utf�rt slike hopp f�r ?',
'alternatives' => array(
	'D-sertifikat eller Instrukt�r 2',
	'Instrukt�r 3',
	'Instrukt�r 1',
	'Instrukt�r 2',
	),
'answer' => array(2),
'chapter' => '506.2',
),

array(
'id' => 132,
'question' => 'Hvem kan v�re hoppfeltleder (HFL) ved natt-, vann- og oksygenhopp ?',
'alternatives' => array(
	'C-sertifikat eller h�yere',
	'D-sertifikat eller h�yere',
	'Instrukt�r 3 eller h�yere',
	'Instrukt�r 2 eller h�yere',
	),
'answer' => array(2),
'chapter' => '507.2',
),

array(
'id' => 133,
'question' => 'Hvem kan <i>normalt sett</i> v�re hoppfeltleder (HFL) n�r elever skal hoppe ?',
'alternatives' => array(
	'A-sertifikat',
	'B-sertifikat',
	'C-sertifikat',
	'D-sertifikat',
	),
'answer' => array(1),
'chapter' => '507.2',
),

array(
'id' => 134,
'question' => 'Hvem kan v�re hoppmester (HM) n�r alle hopperne har A-sertifikat eller h�yere ?',
'alternatives' => array(
	'A-sertifikat',
	'B-sertifikat',
	'C-sertifikat',
	'D-sertifikat',
	),
'answer' => array(1),
'chapter' => '508.2',
),

array(
'id' => 135,
'question' => 'Hvem kan v�re hoppmester (HM) n�r ombordv�rende hoppere er line- eller FF-elever ?',
'alternatives' => array(
	'C-sertifikat',
	'Instrukt�r 3',
	'Instrukt�r 2',
	'Instrukt�r 1',
	),
'answer' => array(1),
'chapter' => '508.2',
),

array(
'id' => 136,
'question' => 'Hvor mange hopp kreves for � kunne ta oppl�ring i CF ?',
'alternatives' => array(
	'150',
	'250',
	'100',
	'50',
	),
'answer' => array(0),
'chapter' => '102.12.4',
),

array(
'id' => 137,
'question' => 'Hva er minsteh�yden for CF-oppl�ring ?',
'alternatives' => array(
	'1500 fot',
	'2500 fot',
	'3500 fot',
	'1800 fot',
	),
'answer' => array(1),
'chapter' => '102.12.1',
),

array(
'id' => 138,
'question' => 'Kan en norsk statsborger med norsk statsborgerskap og <i>utenlandsk sertifikat</i> hoppe fallskjem i Norge ?',
'alternatives' => array(
	'Ja',
	'Nei',
	),
'answer' => array(1),
'chapter' => '100.4.1',
),

array(
'id' => 139,
'question' => 'Hvem har ansvaret for at klubbens materielltjeneste gjennomf�res i samsvar med gjeldende bestemmelser ?',
'alternatives' => array(
	'Klubbstyret',
	'HI',
	'Klubbens MK',
	'Klubbens MR',
	),
'answer' => array(0),
'chapter' => '202.4',
),

array(
'id' => 140,
'question' => 'Hvilket av punktene under er faste normer for kjennelse av Farlig/Ukontrollert (FU) hopping ?',
'alternatives' => array(
	'Eleven trekker 2 sekunder for sent ifht planlagt frittfalltid',
	'Eleven har fosterstilling gjennom hele fallet',
	'Eleven glemmer � si <i>Opp, Ned, Ut</i> ved exit',
	'Eleven f�r enkel tvinn i �pningen',
	),
'answer' => array(1),
'chapter' => '603.3.1',
),

);

?>
