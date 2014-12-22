<? /* $Id: inc-chapters.php 159 2008-05-26 10:54:34Z csl $ */

function get_chapter_title($chapter, $level = 1)
{
	global $_chapters;

	if ( !isset($_chapters[$chapter]) )
		return "";

	$c = $_chapters[$chapter];
	$title = $c['title'];
	//$title = ucfirst(strtolower($c['title'])); // doesnt work with norwegian chars

	return "<h{$level}>$title</h{$level}>\n";
}

function render_chapter_text($chapter, $searchKey = "", $hlevel = 1)
{
	global $_chapters;

	if ( $hlevel < 1 ) $hlevel = 1;

	if ( !isset($_chapters[$chapter]) )
		return "";

	$c = $_chapters[$chapter];
	$s = "";

	if ( isset($c['text']) ) {
		switch ( gettype($c['text']) ) {
		default:
		case 'string':
			$s .= "<p>\n{$c['text']}\n</p>\n";
			break;
		case 'array':
			$s .= "<table>\n";

			if ( strlen($searchKey) && isset($c['text'][$searchKey]) ) {
				$s .= "\t<tr>\n";
				$s .= "\t\t<td>$searchKey</td>\n";
				$s .= "\t\t<td>{$c['text'][$searchKey]}</td>\n";
				$s .= "\t</tr>\n";
			} else {
				foreach ( $c['text'] as $key => $value ) {
					$s .= "\t<tr>\n";
					$s .= "\t\t<td>$key</td>\n";
					$s .= "\t\t<td>$value</td>\n";
					$s .= "\t</tr>\n";
				}
			}

			$s .= "</table>\n";
			break;
		}
	}

	return $s;
}

/*
 * Examples:
 *
 *    get_chapter_text("100.1");
 *    get_chapter_text("100.1", "TMA");
 *    get_chapter_text("100.3");
 *
 */
function get_chapter_text($chapter, $show_parent_headers = true, $searchTerm = "", $clear_parent_text = true)
{
	global $_chapters;

	// get all chapters in a list
	$chapter_parts = explode(".", $chapter);

	// get all titles
	$titles = array();
	foreach ( $chapter_parts as $pos => $part ) {
		$path = implode(".", array_slice($chapter_parts, 0, $pos+1));

		$titles[] = array(
			'index' => $path,
			'title' => get_chapter_title($path, $pos+1),
			'text' => render_chapter_text($path, $searchTerm));
	}

	// clear all text except the innermost
	if ( $clear_parent_text ) {
		$found = false;
		for ( $n=count($titles)-1; $n >= 0; --$n ) {
			if ( $found )
				$titles[$n]['text'] = '';
			else if ( strlen($titles[$n]['text']) )
				$found = true;
		}
	}

	// render as string
	$out = "";
	foreach ( $titles as $part ) {
		// insert index inside <h1>title</h1>
		$part['title'] = ereg_replace('(<h[1-9]+>)', "\\1{$part['index']} ", $part['title']);
		$out .= "{$part['title']}\n";
		$out .= "{$part['text']}\n";
	}
	
	return $out;
}

$_chapters = array(

'100' => array('title' => 'Definisjoner'),

'100.1' => array(
	'title' => 'FORKORTELSER',
	'text' => array(
		'AFF' => 'Accelerated Free Fall - grunnkurs med fritt fall fra 1. hopp (normalt fra 10-13 000 fot).',
		'AGL' => 'Altitude above Ground Level - virkelig h�yde over bakken.',
		'AIC' => 'Aeronautical Information Cirriculum - informasjonssirkul�re utgitt av Avinor og Luftfartstilsynet.',
		'AIP' => 'Aeronautical Information Publication - informasjonssystem utgitt av Avinor til abonnenter. ',
		'BSL' => 'Bestemmelser for Sivil Luftfart.',
		'CF' => 'Canopy Formation ? kalottformasjonshopping (erstatter CRW).',
		'CTR' => 'ConTRol zone - kontrollsone, normalt med radius 8 nm fra en flyplass kontrollt�rn, med h�yde fra bakken opp til en n�rmere angitt h�yde. Andre utstrekninger kan forekomme. Alle CTR er angitt i AIP Norge.',
		'DK' => 'F/NLFs DommerKomite.',
		'F/NLF' => 'Fallskjermseksjonen/Norges Luftsportsforbund.',
		'FL' => 'Flight Level - flygeniv� angitt i 100-fots inndeling, bestemt ved standard atmosf�retrykk (1013.25 hp (hektopascal) = 1 ATA). FL 65 = 6500 fot, FL 100 = 10 000 fot osv.',
		'FMI' => 'FlyMedisinFlyMedisinsk Institutt. FlyMedisinsk Institutt.',
		'FS' => 'Formation Skydiving - fritt fall formasjonshopping.',
		'HFL' => 'HoppFeltLeder.',
		'HI' => 'HovedInstrukt�r.',
		'HL' => 'HoppLeder.',
		'HM' => 'HoppMester.',
		'I' => 'Instrukt�r (alle kategorier instrukt�rer).',
		'I-1' => 'Instrukt�r 1.',
		'I-2' => 'Instrukt�r 2.',
		'I-3' => 'Instrukt�r 3 / Hoppmester.',
		'I-2 AFF' => 'AFF-Instrukt�r 2.',
		'I-3 AFF' => 'AFF-Instrukt�r 3 / AFF-Hoppmester.',
		'I-E' => 'Instrukt�r/Eksaminator.',
		'I-T' => 'Instrukt�r Tandem',
		'MK' => 'MateriellKontroll�r.',
		'MR' => 'MateriellReparat�r.',
		'MSJ' => 'F/NLFs MateriellSJef',
		'MSL' => 'altitude above Mean Sea Level - h�yde over midlere havflateniv�.',
		'NAK/NLF' => 'Norges Luftsportsforbund.',
		'NIF' => 'Norges IdrettsForbund.',
		'nm' => 'nautisk mil = 1852 m.',
		'NOTAM' => 'NOtice To AirMen - publikasjon utgitt av Avinor, NOTAM kl 1 og kl 2: distribueres via Avinors internettjeneste, Air Information Service Norway -  Internet Pilot Planning Centre (www.avinor.no).',
		'OT' => 'OperasjonsTillatelse iht Del 500.',
		'OT-1' => 'OperasjonsTillatelse klasse 1.',
		'OT-2' => 'OperasjonsTillatelse klasse 2.',
		'SU' => 'F/NLFs Sikkerhets- og utdanningskomit�.',
		'TMA' => 'TerMinal Area - terminalomr�de rundt en kontrollert flyplass, med utstrekning og h�ydebegrensning som angitt i AIP Norge.',
		'VFS' => 'Vertical Formation Skydiving - fritt fall formasjonshopping hvor kroppen er vertikalt orientert, dvs <i>head up</i> eller <i>head down</i>.',
		'XT' => 'eXperiment Tillatelse iht Del 500.',
		),
	),

'100.2' => array('title' => 'UTSTYR'),

'100.2.1' => array(
	'title' => 'FALLSKJERM',
	'text' => 'Sammenleggbar ikke-avstivet innretning av duk og liner, som kan foldes ut under fritt fall, og som bremser en persons eller gjenstands frie fall.  Fallskjermer inndeles i kategorier som spesifisert i Del 300.',
	),

'100.2.2' => array(
	'title' => 'HOVEDSKJERM',
	'text' => 'Fallskjerm som er festet til selet�yet med 3-rings frigj�ringssystem, som skal fors�kes brukt under alle fallskjermhopp.',
	),

'100.3' => array(
	'title' => 'FALLSKJERMHOPP',
	'text' => 'Alle planlagte utsprang fra luftfart�y i den hensikt � anvende fallskjerm under hele eller deler av nedstigningen.',
	),

'100.3.1' => array(
	'title' => 'TRENINGSHOPP',
	'text' => 'Fallskjermhopp utf�rt av selvstendig hopper under ordin�r hoppvirksomhet.',
	),

'100.3.6' => array(
	'title' => 'VANNHOPP',
	'text' => 'Fallskjermhopp der det er planlagt � lande i vann dypere enn 1 meter.',
	),

'100.3.7' => array(
	'title' => 'NATTHOPP',
	'text' => 'Fallskjermhopp som utf�res i tidsrommet mellom borgerlig skumring og borgerlig demring (solen 6 grader under horisonten) som angitt i almanakken for gjeldende dag (Civil Twilight).',
	),

'100.3.8' => array(
	'title' => 'OKSYGENHOPP',
	'text' => 'Fallskjermhopp fra h�yder over 15 000 fot MSL.',
	),

'100.3.10' => array(
	'title' => 'ALMINNELIG HOPPING',
	'text' => 'Hopping omfattende treningshopp, utdanningshopp og konkurransehopp.',
	),

'100.3.11' => array(
	'title' => 'SPESIELLE HOPPTYPER',
	'text' => '<p>Tandemhopp, oppvisningshopp, vannhopp, natthopp og oksygenhopp.</p><p>Slep etter fly og hopping med to hovedskjermer regnes ogs� som spesielle hopptyper. Disse hopptypene er ikke tillatt utf�rt uten gyldig eksperimenttillatelse for denne typen hopping. </p>',
	),

'100.4' => array('title' => 'SERTIFIKAT'),

'100.4.1' => array(
	'title' => 'FALLSKJERMSERTIFIKAT UTSTEDT AV F/NLF',
	'text' => 'Fallskjermhoppere som er norske statsborgere og bosatt i Norge skal ha gyldige norske sertifikater utstedt av NAK/NLF for � delta i hopping i regi av F/NLF.',
	),

'100.4.2' => array(
	'title' => 'FAI-SERTIFIKAT',
	'text' => 'Gyldig utenlandsk fallskjermsertifikat godkjent i henhold til FAI Sporting Code Section 5.  Innehaveren gis rettigheter i henhold til F/NLFs bestemmelser Del 300 etter FAIs til enhver tid gjeldende krav til <i>International Certificates of Proficiency</i>.',
	),

'100.5' => array('title' => 'HOPPERSTATUS'),

'100.5.1' => array(
	'title' => 'ELEV',
	'text' => 'Innehaver av gyldig norsk elevbevis i henhold til F/NLFs Bestemmelser Del 300. ',
	),

'100.5.1.1' => array(
	'title' => 'TANDEMELEV',
	'text' => 'Person som oppfyller krav til tandemelev iht pkt 103.5.2.',
	),

'100.5.2' => array(
	'title' => 'SELVSTENDIG HOPPER',
	'text' => 'Innehaver av gyldig norsk A-sertifikat eller h�yere i henhold til F/NLFs Bestemmelser Del 300, eller tilsvarende FAI sertifikat. ',
	),

'100.6' => array(
	'title' => 'LUFTFART�Y',
	'text' => 'Ethvert apparat som kan holdes oppe i atmosf�ren ved reaksjoner fra luften, dog ikke ved reaksjoner av luft mot jordoverflaten.',
	),

'100.7' => array('title' => 'H�YDE'),

'100.7.1' => array(
	'title' => '�PNINGSH�YDE',
	'text' => 'Vertikal avstand til bakken p� �pningspunktet. Ved kupert terreng regnes h�yden over h�yeste punkt innen 500 m radius fra det beregnede �pningspunkt. Unntatt fra dette er h�ydeangivelser der betegnelsen MSL (Mean Sea Level = midlere havflateniv�) er anvendt. I s� fall forst�s h�yden som h�yde over havflateniv�.', 
	),

'100.7.2' => array(
	'title' => 'UTSPRANGSH�YDE',
	'text' => 'Den h�yde der fallskjermhopperen forlater luftfart�yet.',
	),

'100.7.3' => array(
	'title' => 'TREKKH�YDE',
	'text' => 'Den h�yde der skjermen aktiveres.',
	),

'100.8' => array( 'title' => 'VIND'),

'100.8.1' => array(
	'title' => 'BAKKEVIND',
	'text' => 'Vindhastigheten m�lt 3-7 m over bakkeniv� innenfor hoppfeltet. Styrken m�les som sterkeste vindkast innenfor en 10 minutters periode.',
	),

'100.8.2' => array(
	'title' => 'MIDDELVIND',
	'text' => 'Vindhastigheten som gjennomsnittet av luftstr�mmene fra hoppfeltets niv� opp til 2 000 fots h�yde. Middelvinden angis som driverens avdrift i distanse. ',
	),

'100.8.3' => array(
	'title' => 'H�YDEVIND',
	'text' => 'Vindhastigheten over 2 000 fots h�yde. Normalt fastsettes h�ydevinden p� grunnlag av sonderapporter fra meteorologiske stasjoner, eller ved observasjoner under flyging. ',
	),

'100.9' => array(
	'title' => 'HOPPFELT',
	'text' => 'Et omr�de som omfatter s� vel landingsomr�de som dets omgivelser i den utstrekning det m� ventes at hoppere vil kunne komme til � lande der.'
	),

'100.9.1' => array(
	'title' => 'LANDINGSOMR�DE',
	'text' => 'Den del av hoppfeltet der hopperne forutsettes � lande.',
	),

'100.9.2' => array(
	'title' => '�PNINGSPUNKT',
	'text' => 'Det punktet i terrenget som det er planlagt at hopperen skal befinne seg over ved skjerm�pning. ',
	),

'100.10' => array(
	'title' => 'M�LEENHETER',
	'text' => 'Under gjennomf�ring av fallskjermhopping skal alltid f�lgende m�leenheter anvendes:',
	),

'100.10.1' => array(
	'title' => 'H�YDEANGIVELSER',
	'text' => 'FOT. Ved eventuelle omregninger settes 1 fot lik 0.3 m og 1 m lik 3.3 fot.',
	),

'100.10.2' => array(
	'title' => 'DISTANSEANGIVELSER',
	'text' => 'METER.',
	),

'100.10.3' => array(
	'title' => 'VINDSTYRKE',
	'text' => 'KNOTS. Ved omregning anvendes 1 knot lik 0.5 m/sek og 1 m/sek lik 2 knots.',
	),

'102' => array(
	'title' => 'ALMINNELIGE BESTEMMELSER',
	'text' => 'Disse alminnelige bestemmelser gjelder for alle fallskjermhopp under alle forhold, unntatt der det er gitt egne bestemmelser for spesielle typer hopp.',
	),

'102.1' => array(
	'title' => 'ALDERSGRENSE',
	'text' => 'Ingen tillates � gjennomf�re fallskjermhopp eller p�begynne fallskjermutdannelse f�r vedkommende er fylt 16 �r.  Personer som ikke er fylt 18 �r skal ha skriftlig tillatelse fra foresatte.',
	),

'102.2' => array(
	'title' => 'SERTIFIKATER/BEVISER',
	'text' => 'Ingen tillates � gjennomf�re fallskjermhopp uten � ha gyldig elevbevis eller sertifikat, iht. bestemmelsene i Del 300.',
	),

'102.3' => array(
	'title' => 'FYSISK/PSYKISK TILSTAND',
	'text' => 'Ingen skal gjennomf�re eller tillate gjennomf�rt fallskjermhopp av noen som �penbart er p�virket av alkohol (ikke edru) eller annet berusende eller bed�vende middel eller p� grunn av sykdom, legemidler, tretthet eller lignende �rsak er uskikket til � hoppe p� en trygg m�te. Den som deltar i fallskjermhopping, m� ikke ha en alkoholkonsentrasjon i blodet som overstiger 0,2 promille.',
	),

'102.4' => array('title' => 'UTSTYR'),

'102.4.1' => array('title' => 'FALLSKJERMER'),

'102.4.1.1' => array(
	'title' => 'VINGBELASTNING',
	'text' => 'Forholdet mellom hopperens vekt ved utsprang fra luftfart�y og st�rrelsen p� hovedskjerm skal ikke overstige:<ul><li>0,95 hhv 1,0 lb/sqft for elever </li></ul>F�rstegangshoppere og uerfarne elever skal ha en lavere vingbelastning enn 0,95. Erfarne elever som hopper 0P/hybrid kan overstige 0,95 men aldri 1.0 i vingebelastning.  Vekt p� utstyret og bekledning som skal legges til kroppsvekten skal v�re 15 kg <span style="color:red;">for hopping med elevutstyr og 12 kg for hopping med sportsutstyr</span>. <ul><li>1,1 lb/sqft for hoppere med mindre enn 200 hopp</li><li>1,3 lb/sqft for hoppere med mindre enn 350 hopp</li><li>1,6 lb/sqft for hoppere med mindre enn 500 hopp</li></ul>',
	),

'102.4.2' => array(
	'title' => 'HJELM',
	'text' => '<p>Hoppere skal alltid v�re utstyrt med hjelm. </p><p>Fallskjermhjelm skal beskytte hodet. Under hopping kan f�lgende hjelmer nyttes:</p><ul><li>Hjelmer spesielt produsert for fallskjermhopping. </li><li>Sports- og motorsykkelhjelmer etter godkjenning av Instrukt�r 1. </li></ul><p>Elever skal benytte hjelm med hardt skall. </p><p>Hjelm med p�montert videokamera og/eller fotografiapparat skal godkjennes for bruk av HI.</p> ',
	),

'102.4.6' => array(
	'title' => 'H�YDEM�LER',
	'text' => '<p>Hopper skal under alle hopp v�re utstyrt med visuell h�ydem�ler. Visuell h�ydem�ler skal v�re produsert spesielt for fallskjermhopping.  Akustisk h�ydevarsler kan supplere, men ikke erstatte h�ydem�ler.  H�ydem�ler skal v�re montert slik at den er fullt leselig under hele hoppet, og slik at den ikke er til hinder for skjermens aktivering eller gjennomf�ring av n�dprosedyre.</p><p>Planlagt vannhopp med utsprang under 5 000 fot kan gjennomf�res uten h�ydem�ler.</p>',
	),

'102.5' => array(
	'title' => 'UTSPRANGS- OG TREKKH�YDER',
	),

'102.5.1' => array(
	'title' => 'TREKKH�YDE VED UTSPRANG OVER 2 500 FOT',
	'text' => 'Trekk skal utf�res slik at hopper ved normalt �pningsforl�p vil oppn� flygende hovedskjerm 2 000 fot AGL. Minste tillatte vertikal avstand til bakken under fritt fall er 2500 fot AGL.  Se ogs� pkt 100.7.1',
	),

'102.5.2' => array(
	'title' => 'UNDER 2500 FOT',
	'text' => 'Ved utsprangsh�yder 2 500 fot eller lavere, skal trekket utf�res innen 2 sek etter utspranget.',
	),

'102.5.3' => array(
	'title' => 'LAVESTE H�YDE FOR ELEVER / ELEVUTSTYR',
	'text' => '<p>For hopp p� progresjonsplan etter Grunnkurs del II er laveste tillatte utsprangsh�yde 3 500 fot, og laveste trekkh�yde 3 000 fot. Laveste tillatte utsprangsh�yde for linehopp er 3 000 fot.</p><p>For hopp p� progresjonsplanen etter Grunnkurs AFF, niv� 1 til 7 er laveste tillatte utsprangsh�yde 9 000 fot.</p><p>Denne bestemmelsen gjelder alle tilfeller der elevfallskjermsett med n�d�pner type FXC 12000 benyttes, uansett hopperens erfaringsniv� og sertifikat, og uavhengig av om n�d�pner er p�/av. </p>',
	),

'102.5.4' => array(
	'title' => 'LAVESTE UTSPRANGSH�YDE FOR SELVSTENDIGE HOPPERE',
	'text' => 'Laveste tillatte utsprangsh�yde er 1 500 fot. Er flyhastigheten ved utspranget lavere enn 60 knots, er laveste utsprangsh�yde 1 800 fot.',
	),

'102.5.5' => array(
	'title' => 'H�YDEBEGRENSNING',
	'text' => '<p>Alminnelig fallskjermhopping skal ikke utf�res fra st�rre h�yder enn 15 000 fot MSL. Fallskjermhopp fra st�rre h�yder enn 15 000 fot MSL skal utf�res iht bestemmelsene om oksygenhopp.</p><p>Ved utsprang mellom 13 000 fot og 15 000 fot MSL er maksimalt tillatt eksponeringstid over 13 000 fot er 10 minutter.</p>',
	),

'102.6' => array(
	'title' => 'VINDGRENSER',
	),

'102.6.1' => array(
	'title' => 'GENERELL GRENSE',
	'text' => 'Fallskjermhopp skal ikke utf�res dersom bakkevinden overstiger 22 knots.',
	),

'102.6.2' => array(
	'title' => 'GRENSE FOR ELEVER',
	'text' => '<p>For elever er bakkevindsgrensen 14 knots. Elever skal ikke tillates � hoppe i st�rre middelvindstyrke enn 25 knots (1 250 m driverdistanse).</p><p>S�rlig erfarne elever kan av Hoppleder tillates � hoppe ved bakkevind inntil 18 knots og middelvindstyrke over 25 knots.</p>',
	),

'102.6.3' => array(
	'title' => 'VINDGRENSE FOR HOPPERE MED RUND RESERVE',
	'text' => 'For hoppere utstyrt med rund reserve er bakkevindgrensen 18 knots.',
	),

'102.7' => array('title' => 'KONTROLL AV VINDFORHOLD', text => 'Middelvindens retning og styrke skal alltid fastsl�s p� en av f�lgende m�ter:'),

'102.7.1' => array(
	'title' => 'DRIVER',
	'text' => 'Med vinddriver best�ende av en krepp-papirremse p� 25 x 625 cm, med en vekt p� 30 gram i den ene enden, sluppet fra den planlagte �pningsh�yden.  Eventuelt kan annen tilsvarende innretning benyttes. Driver eller annen innretning skal ha en synkehastighet p� 20 fot pr sek, (100 sek fra 2 000 fot).',
	),

'102.8' => array('title' => 'HOPPFELT FOR ALMINNELIG HOPPING', text => 'Hoppfelt som skal anvendes for alminnelig fallskjermhopping skal tilfredsstille f�lgende krav:'),

'102.8.1' => array(
	'title' => 'OMFANG',
	'text' => '<p>Hoppfeltet skal ha en diameter p� minst 200 m, der det ikke skal finnes vesentlige faremomenter for hopperne.</p><p>Tr�r, skog, gjerder ol regnes ikke som vesentlige faremomenter, dog b�r ikke st�rre skogfelter forekomme.</p>',
	),

'102.8.1.1' => array(
	'title' => 'HOPPFELT FOR HOPPERE MED A-SERT. OG H�YERE STATUS',
	'text' => 'Treningshoppfelt for hoppere med A-sertifikat og h�yere skal ha en diameter p� minst 150 m, med et landingsomr�de som angitt i pkt. 102.8.2. Hoppfeltets beskaffenhet skal v�re som pkt. 102.8.1.'),

'102.8.1.2' => array(
	'title' => 'HOPPFELT FOR D-HOPPERE',
	'text' => 'Hoppfelt med begrenset hopping utf�rt av D-hoppere godkjennes av hopperne selv. Dog gjelder krav til landingsomr�de som for oppvisningshopp.',
	),

'102.8.3' => array(
	'title' => 'VANN',
	'text' => '<p>Redningsmateriell som ved vannhopp skal forefinnes ved hopping dersom vann dypere enn 1 m finnes innenfor 1 000 m fra beregnet landingspunkt. </p><p>Redningsvest godkjent iht Del 200 skal benyttes dersom �pent vann, innsj� eller sj� dypere enn 1 m finnes innenfor:</p>',
	),

'102.8.3.1' => array(
	'title' => 'ELEVER, HOPPERE MED A-SERTIFIKAT OG HOPPERE MED RUND RESERVESKJERM',
	'text' => '1 000 m fra beregnet landingspunkt.  Elever tillates ikke � benytte oppbl�sbar redningsvest uten trykkpatron. ',
	),

'102.8.3.2' => array(
	'title' => 'HOPPERE MED B- TIL OG MED D-SERTIFIKAT OG FOR TANDEMHOPPING',
	'text' => '250 m fra beregnet landingspunkt.',
	),

'102.8.3.3' => array('title' => 'HOPPERE MED DEMOSERTIFIKAT', 'text' =>
	'250 m fra beregnet landingspunkt, og korteste utstrekning p� vannet (fra bredd til bredd) innenfor omr�det er lengre enn 100 meter.'),

'102.9' => array('title' => 'SIGNALSYSTEM FRA BAKKE TIL FLY', 'text' => 'Ved all fallskjermhopping skal det v�re et signalsystem mellom bakketjenesten og luftfart�yet. Dette kan skje ved en av f�lgende metoder:'),

'102.9.1' => array('title' => 'JORDTEGN', 'text' =>
	'Jordtegn lagt ut p� en slik m�te at det klart kan sees fra flyet. Midlertidig hoppforbud markeres ved at tegnet legges som en linje. Hoppforbud markeres ved at hele tegnet tas inn.'),

'102.11' => array('title' => 'FRITT FALL FORMASJONSHOPPING (FS/VFS)', 'text' => 'Ved alle hopp der to eller flere hoppere har til hensikt � oppn� kontakt eller fly "non contact" i fritt fall, gjelder f�lgende bestemmelser: '),

'102.11.1' => array('title' => 'H�YDEBEGRENSNING', 'text' =>
	'Det er ikke tillatt � ha kontakt mellom hoppere i fritt fall under 3 500 fot. Ved separasjon skal hopperne fjerne seg fra hverandre tilstrekkelig til � unng� kollisjon under eller etter skjerm�pning.'),

'102.11.2' => array('title' => 'VIKEPLIKT', 'text' =>
	'<p>Under alle man�vrer i fritt fall har overliggende hopper vikeplikt, og det p�ligger overliggende hopper � p�se at han ikke er i en posisjon som kan medf�re fare i forhold til underliggende hoppere. </p><ul><li>F�r trekk skal hopperne gi tegn ved � vifte med begge hender (wave off) i ca. 2-3 sek., slik at overliggende hoppere skal kunne fjerne seg.</li></ul>'
	),

'102.11.3' => array('title' => 'KVALIFIKASJONER',
	'text' => 'Formasjonshopping tillates ikke utf�rt av hoppere med elevbevis. Unntatt fra dette er oppl�ring i formasjonshopping slik denne er beskrevet i del 600 med vedlegg.  For hoppere med A-sertifikat gjelder begrensninger anf�rt i del 300.'),

'102.12' => array('title' => 'KALOTT FORMASJONSHOPPING (CF)', 'text' =>
	'Ved alle hopp der to eller flere hoppere har til hensikt � oppn� kontakt eller fly "non contact" etter skjerm�pning, skal f�lgende bestemmelser etterf�lges:'),

'102.12.1' => array('title' => 'H�YDEBEGRENSNING',
	'text' => '<p>Det er ikke tillatt � fors�ke � oppn� kontakt (docking) mellom to hoppere i skjerm under 1 500 fot. Ved kalottformasjoner med flere enn to hoppere, er minsteh�yden 2 500 fot.  </p><p>Under oppl�ring i CF er minsteh�yden uansett 2 500 fot. </p>',
	),

'102.12.4' => array('title' => 'OPPL�RING',
	'text' => 'F�lgende bestemmelser gjelder for oppl�ring i CF: <ul><li>Minimum 150 hopp</li><li>Gjennomg�tt F/NLFs teorikurs</li><li>avlagt pr�ve overfor Instrukt�r 1 (Ref Del 600).</li></ul>Godkjenning for gjennomg�tt teorikurs skal v�re attestert for i hopperens loggbok. ',
	),

'103' => array('title' => 'SPESIELLE BESTEMMELSER'),

'103.1' => array('title' => 'BESTEMMELSER FOR OKSYGENHOPP'),

'103.1.1' => array('title' => 'OVER 15 000 FOT MSL', 'text' => 'Utsprang fra h�yder over 15 000 fot betinger bruk av oksygenutstyr og personell, bestemmelser og opplegg skal godkjennes av SU i hvert enkelt tilfelle. '),

'103.2' => array('title' => 'BESTEMMELSER FOR NATTHOPP', 'text' => 'Ved all fallskjermhopping som utf�res mellom borgerlig skumring og borgerlig demring som angitt i almanakken, skal f�lgende regler etterf�lges:'),

'103.2.4' => array('title' => 'KVALIFIKASJONER',
	'text' => '<p>Natthopp tillates bare utf�rt av hoppere med C-sertifikat eller h�yere. Hoppere skal f�r de tillates � utf�re natthopp ha gjennomg�tt teorikurs og avlagt pr�ve overfor Instrukt�r 1.</p><p>Godkjenning for gjennomf�rt teorikurs skal v�re attestert for i hopperens loggbok.</p>',
	),

'103' => array('title' => 'BESTEMMELSER FOR VANNHOPP', 'text' =>
	'For alle fallskjermhopp der det er planlagt landing i vann dypere enn 1 m skal f�lgende bestemmelser etterf�lges:'
	),

'103.3.4' => array('title' => 'KVALIFIKASJONER',
	'text' => '<p>Vannhopp tillates bare utf�rt av hoppere med minst B-sertifikat. Hoppere skal, f�r de tillates � utf�re vannhopp, ha gjennomg�tt teorikurs og avlagt pr�ve overfor Instrukt�r 1.</p><p>Godkjenning for gjennomf�rt teorikurs skal v�re attestert for i hopperens loggbok.</p>',
	),

'103.4' => array('title' => 'BESTEMMELSER FOR OPPVISNINGSHOPP'),

'103.4.5' => array('title' => 'AVSTAND TIL PUBLIKUM ',
	'text' => 'Avstand mellom landingsomr�de og publikum skal v�re st�rre enn 15 meter horisontalt og 25 fot vertikalt. Jfr BSL D 4-3.'),

'103.5' => array('title' => 'BESTEMMELSER FOR TANDEMHOPPING'),

'103.5.4' => array('title' => 'UTSPRANGS- OG TREKKH�YDE',
	'text' => 'For tandemhopping er laveste tillatte utsprangsh�yde 7500 fot, og laveste trekkh�yde 5000 fot.'
	),

'200' => array('title' => 'MATERIELLREGLEMENT'),

'201' => array('title' => 'GENERELT'),

'201.4' => array('title' => 'OVERHOLDELSE/DISIPLIN�RTILTAK', 'text' =>
	'Alle som ut�ver materielltjeneste etter disse bestemmelser plikter � kjenne de deler av bestemmelsene som ang�r vedkommendes oppgaver, og plikter � overholde dem p� alle punkter.'
	),

'201.4.1' => array('title' => 'P�TALE AV BRUDD',
	'text' => '<p>Et hvert medlem av Fallskjermseksjonen/NLF har rett og plikt til � gripe inn ved brudd p� Materiellreglementets bestemmelser.</p><p>Brudd p� bestemmelsene i Del 200 er rapporteringspliktige jfr Del 500.</p>',
	),

'202' => array('title' => 'ORGANISASJON'),

'202.4' => array('title' => 'KLUBBSTYRET', 'text' =>
	'Det lokale klubbstyre har uten unntak ansvaret for at klubbenes materielltjeneste gjennomf�res i samsvar med gjeldende bestemmelser.'
	),

'202.7' => array('title' => 'EIER AV MATERIELL', 'text' =>
	'Eier av materiell er selv ansvarlig for dette. Eier av fallskjerm betraktes som skjermens materiellforvalter. Hovedkontroll, reservepakking og eventuell annen �nsket kontroll foretas av Materiellkontroll�r.'
	),

'206' => array('title' => 'PAKKING', 'text' =>
	'<p>Selvstendig pakking kan kun gj�res av de som har gyldig pakkersertifikat for vedkommende kategori fallskjerm, ref del 300. Pakkekontroll skal utf�res etter bestemmelser i Materiellh�ndboken.  Pakking skal skje iht.  fallskjermprodusentens pakkemanual. </p>'.
	'<p>Fallskjermens l�ftestropper skal v�re festet til selet�y/pakksekk n�r fallskjermen pakkes.</p>'.
	'<p>Foreligger det mistanke om at v�te, urenheter etc kan ha trukket gjennom/inn i pakksekken skal denne �pnes og skjermen kontrolleres. Skjermen t�rkes og renses f�r pakking i de tilfeller hvor dette m�tte vise seg n�dvendig.</p>',
	'<p>�pen ild skal ikke forekomme innenfor 50 m avstand fra fallskjermmateriell.</p>'
	),

'206.1' => array('title' => 'OMPAKKINGSSYKLUS', 'text' =>
	'Hovedfallskjermer, reserveskjermer i elevutstyr, reserveskjermer i tandemutstyr og reserveskjermer i andre felleseide fallskjermsett som har v�rt lagret i pakket stand i mer enn 6 m�neder, er ikke luftdyktig.  Reservefallskjermer i privateid sportsutstyr kan lagres i 12 m�neder.  For igjen � bli luftdyktig m� fallskjermen luftes ved at den �pnes og ristes grundig f�r den pakkes p� ny. '
	),

'206.2' => array('title' => 'PAKKEKONTROLL'),

'206.2.1' => array('title' => 'VINGSKJERMER', 'text' =>
	'For vingskjermer foretas pakkekontrollen slik:'.
	'<ul>'.
	'<li>1. kontroll: N�r kalotten er lagt ned p� siden med linene og kalotten strukket ut (gjelder ikke ved pro-pakking).</li>'.
	'<li>2. kontroll: N�r kalotten er brettet sammen, panelene trukket ut, halen lagt, slideren trukket opp.</li>'.
	'<li>3. kontroll: N�r kalotten er brettet sammen og lagt i bagen, linene sl�yfet inn og bagen lagt inn i pakksekken.</li>'.
	'<li>4. kontroll: N�r sekken er lukket. </li>'.
	'</ul>',
	),

'207' => array('title' => 'KONTROLL AV FALLSKJERMUTSTYR', 'text' =>
	'Kontroll av fallskjermutstyr omfatter <ul><li>Hovedkontroll</li><li>Brukskontroll</li></ul>'
	),

'207.1' => array('title' => 'HOVEDKONTROLL'),

'207.1.2' => array('title' => 'INTERVALLER', 'text' =>
	'Fallskjermsett skal underkastes hovedkontroll:'.
	'<ul>'.
	'<li>F�r fallskjermsettet kan tas i bruk (f�rstegangs kontroll).</li>'.
	'<li>Innen 6 m�neder etter siste hovedkontroll for elevfallskjermsett, tandemfallskjermsett og fallskjermsett som er felleseid klubbutstyr. </li>'.
	'<li>Innen 12 m�neder etter siste hovedkontroll for annet utstyr.</li>'.
	'<li>Etter utf�rt st�rre reparasjon.</li>'.
	'<li>Etter feilfunksjonert hovedskjerm.</li>'.
	'<li>Etter aktivert reserveskjerm (kontrolleres sammen med selet�y/pakksekk.)</li>'.
	'<li>N�r det er �nskelig av ansvarlig pakker, materiellforvalter eller eier.</li>'.
	'</ul>'.
	'<p>'.
	'Elevfallskjermsett, tandemfallskjermsett og fallskjermsett som er felleseid klubbutstyr er luftdyktig i 3 m�neder etter gjennomf�rt hovedkontroll. Deretter m� brukskontroll iht 207.2 gjennomf�res for at utstyret skal v�re luftdyktig fram til neste forfall for hovedkontroll.'.
	'</p>'
	),

'208' => array('title' => 'BESTEMMELSER SOM SKAL FLYTTES TIL MATERIELLH�NDBOKEN'),

'208.2' => array('title' => 'KASSASJON AV FALLSKJERMER'),

'208.2.3' => array('title' => 'KASSASJONSGRUNNLAG'),

'208.2.3.2' => array('title' => 'FALLSKJERMER SOM HAR V�RT I KONTAKT MED SJ�VANN (SALTVANN)', 'text' =>
	'Komponenter som har v�rt i kontakt med sj�vann (saltvann), i mer enn 48 timer, eller som ikke har blitt skyllet tilfredsstillende innen 24 timer etter berging, skal kasseres.'
	),

'208.2.4' => array('title' => 'ANVENDELSE AV KASSERT MATERIELL', 'text' =>
	'<p>Kryss skal males diagonalt over pakksekken, og over skjermens serienummer. Bruk kontrastfarget maling.</p>'.
	'<p>Kasserte fallskjermer (�vingsmateriell) skal lagres separat fra luftdyktig utstyr.</p>'
	),

'208.5' => array('title' => 'RESERVESKJERMEN', 'text' => 
	'<p>Reserveskjermen er en rund kalott eller vingfallskjerm. Kun skjermer som er produsert for anvendelse som n�dskjerm (low speed type parachute) kan godkjennes. Runde kalotters synkehastighet skal ikke overskride 7,5 m/sek ved en belastning p� 75 kg vekt. </p>'.
	'<p>Kategoriinndeling er som beskrevet i Del 300.</p>'.
	'<p>Reserveskjermen best�r av pilotskjerm med b�nd, innerbag/diaper, kalott med b�reliner og links (sjakler), utl�serh�ndtak med kabel og pinne(r), samt pakkerlogg.</p>'.
	'<p>Pilotskjermen skal v�re godkjent av selet�yprodusenten, og festes til runde skjermers toppliner ved hjelp av pilotb�ndet. Ved vingreserver skal riggprodusentens fribagsystem nyttes. Type b�nd, lengde og festemetode er beskrevet i Materiellh�ndboken. </p>'.
	'<p>Selet�y skal v�re utstyrt med tilkoplet LOR/RSL line slik det er beskrevet av produsenten eller av annen godkjent type for automatisk aktivering av reserveskjerm ved cut away fra utl�st, ikke flyvende hovedskjerm.</p>'.
	'<p>Dersom typegodkjent n�d�pner vedlikeholdt iht. produsentens krav er montert og i bruk p� reserveskjermen kan LOR/RSL-line demonteres. </p>'
	),

'209' => array('title' => 'ANNET FALLSKJERMMATERIELL - FLYTTES TIL MATERIELLH�NDBOKEN'),

'209.1' => array('title' => 'UTL�SERLINE', 'text' =>
	'Linen skal ha en bruddstyrke p� minst 1000 kg, og v�re 3,90 m lang om ikke annet er bestemt av produsenten eller blir fastsatt for bruk i forbindelse med bestemt flytype. Utl�serlinen skal ha godkjent type ankerkrok med sikringspinne. Utl�serlinen skal ha krum pinne, eller annen godkjent anordning for l�sing av pakksekk. Ved utsprang fra stag skal utl�serlinen v�re innsydd til halv bredde for � redusere vindfang. '
	),

'213' => array('title' => 'GODKJENNING / VEDLIKEHOLD AV ANNET MATERIELL - FLYTTES TIL MATERIELLH�NDBOKEN'),

'213.2' => array('title' => 'FLYTEVEST', 'text' =>
	'<p>Flytevester skal v�re godkjent av Materiellkontroll�r. Godkjenning skal skje iht f�lgende:</p>'.
	'<ul>'.
	'<li>Vesten kan v�re oppbl�sbar eller av fast materiale.</li>'.
	'<li>Vesten skal under ingen omstendighet kunne v�re til fare for hopperen eller til hinder for utl�sning av fallskjermen eller frigj�ring fra selet�yet.</li>'.
	'<li>Vesten skal ha en oppdrift p� minimum 50 Newton.</li>'.
	'<li>Oppbl�sbare vester uten trykkpatron kan godkjennes hvis ventil for innbl�sing av luft vurderes � v�re lett tilgjengelig under bruk.</li>'.
	'<li>Oppbl�sbare vester med trykkpatron kan godkjennes hvis aktiveringsmekanisme vurderes � v�re lett tilgjengelig under bruk.</li>'.
	'<li>Flytevester som er spesielt �mfintlige for slitasje kan anvendes n�r de er utstyrt med overtrekk.</li>'.
	'</ul>'.
	'<p>Felleseide flytevester skal underkastes kontroll av Materiellkontroll�r n�r det anses n�dvendig, dog minst en gang �rlig. </p>'
	),

'300' => array('title' => 'FALLSKJERMSERTIFIKATER'),

'300.1' => array('title' => 'FRITT FALL', 'text' =>
	'Med fritt fall menes her et hopp der hopperen selv utl�ser sin skjerm etter at han har forlatt luftfart�yet.'
	),
	
'301' => array('title' => 'GENERELT'),

'301.1' => array('title' => 'UTSTEDELSE', 'text' =>
	'<p>F/NLFs fallskjermsertifikater er kompetansebevis som utstedes av Sikkerhets- og utdanningskomiteen F/NLF til medlemmer av F/NLF og lokalklubbene etter s�knad p�f�rt attestasjon om at kravene er oppfylt. Etter utstedelse av sertifikat plikter s�keren i gyldighetsperioden til enhver tid � underkaste seg doping- eller rusmiddelkontroll, herunder utvidet blodpr�ve. </p>'.
	'<p>S�knader om utstedelse av elevbevis, fallskjermsertifikat eller lisens sendes NLFs sekretariat, p�f�rt attestasjon av Instrukt�r 1 eller h�yere. Instrukt�ren er ansvarlig for at s�knaden samsvarer med gjeldene vedlikeholdskrav.  S�knader om fornyelse sendes NLFs sekretariat, p�f�rt attestasjon av Instrukt�r 2 eller h�yere.</p>'.
	'<p>Fallskjermpakkersertifikat utstedes etter anbefaling fra Instrukt�r 1 eller Materiellkontroll�r, med bekreftelse om tilfredsstillende gjennomf�rt eksamenspr�ve.</p>'.
	'<p>Alle sertifikater er nummerert, og NLF f�rer register over alle utstedelser og fornyelser.</p>'
	),

'301.2' => array('title' => 'GYLDIGHET', 'text' =>
	'<p>Sertifikatene utstedes for livstid, men er kun gyldig for deltakelse i praktisk hopping i den perioden de er utstedt eller fornyet for, og ved samtidig gyldig og betalt medlemskap i F/NLF.  Kriterier for medlemskap, straffeforf�yninger og gjenopptak er gitt i NIFs og NLFs lover. </p>'.
	'<p>Sertifikat anses gyldig ved postlegging av skjema for utstedelse eller fornyelse, dersom dette er bevitnet av instrukt�r 2 eller h�yere.</p>'.
	'<p>Fallskjermpakkersertifikat er automatisk gyldig dersom innehaveren ogs� har gyldig fallskjermsertifikat av klasse A eller h�yere. Ellers gjelder vedlikeholdsbestemmelsene i pkt 304.8.</p>',
	),

'301.5' => array('title' => 'FORNYELSE', 'text' =>
	'Fornyelse av sertifikater utf�res av NLFs sekretariat etter s�knad med attestasjon av Instrukt�r 2 eller h�yere for at fornyelseskravene er oppfylt. Fornyelse skjer for 365 dager.  Instrukt�r kan ikke fornye egne sertifikater.'
	),

'308' => array('title' => 'A-SERTIFIKAT'),
'308.1' => array('title' => 'KVALIFIKASJONS- OG FERDIGHETSKRAV'),
'308.1.1' => array('title' => 'MED BAKGRUNN I GRUNNKURS, LINE', 'text' =>
	'Fullf�rt progresjonsplan iht Del 600. Minst 20 godkjente fritt fall hopp. Minst 10 hopp med landing innenfor 50 meter. Utsjekk firkantreserve, utsjekk h�yverdig firkantskjerm.  Deltatt p� A-sertfikatkurs under ledelse av instrukt�r 2. Inneha pakkesertifikat for hovedskjerm kategori 1.  Avlagt teoripr�ve med tilfredsstillende resultat overfor Instrukt�r 1, i H�ndbokas Del 100, Del 200 og Del 500. '
	),

'308.2' => array('title' => 'RETTIGHETER OG BEGRENSNINGER', 'text' =>
	'<p>A-sertifikat gir innehaveren rett til � gjennomf�re solo fritt fall under ledelse og kontroll av Hoppleder, og til � hoppmestre seg selv p� solo fritt fall hopp.  A-sertifikat gir hopperen rett til � hoppe med typegodkjent privateid fallskjermsett (fallskjermsett som ikke er elevskjermsett).</p>'.
	'<p>Innehaver av A-sertifikat kan kun delta i formasjonshopping (FS, VFS) under praktisk oppl�ring av instrukt�r.  Formasjonene m� ikke best� av mer enn totalt tre hoppere. </p>'.
	'<p>Innehaveren betegnes "Solo frittfall hopper / parachutist".</p>'
	),

'308.3' => array('title' => 'FORNYELSESKRAV'),

'308.3.1' => array('title' => 'GENERELT KRAV', 'text' =>
	'<p>Gjennomf�rt minimum 20 fallskjermhopp siste 365 dager.</p>',
	'<p>HI kan unntaksvis og etter individuell vurdering fornye A-sertifikat med f�rre enn 20 hopp de siste 365 dager.  Dersom dette gj�res skal HI vedlegge en s�rskilt vurdering n�r fornyelsespapirene sendes til F/NLF.</p>',
	),

'309' => array('title' => 'B-SERTIFIKAT', 'text' => ''),

'309.1' => array('title' => 'KVALIFIKASJONS- OG FERDIGHETSKRAV', 'text' =>
	'<p>Inneha A-sertifikat.  Minst 50 godkjente fritt fall hopp.  Mer enn 30 minutter akkumulert frittfall tid.</p>'.
	'<p>Fullf�rt progresjonshopp for A-sertifikat omfattende skjermkontroll og sikkerhet under formasjonshopping (FS og VFS).</p>',
	'<p>Avlagt skriftlig pr�ve overfor Instrukt�r 1 omfattende H�ndbokens del 100, 200, 300, 400 og 500.</p>'
	),

'309.2' => array('title' => 'RETTIGHETER OG BEGRENSNINGER', 'text' =>
	'<p>B-sertifikatet gir innehaveren rett til � delta i praktisk hopping under ledelse og kontroll av Hoppleder, og til � hoppmestre seg selv.  Det gir rett til � delta i konkurranser, nasjonalt og internasjonalt.  B-sertifikatet gir ogs� rett til � attestere i hopplogg for andre hoppere med A-sertifikat eller hoyere, dog ikke for de spesielle progresjonshopp som skal kontrolleres av Instruktor.</p>'.
	'<p>B-sertifikatet gir hopperen rett til � fungere som Hoppfeltleder, med plikter og rettigheter iht Del 500.</p>'.
	'<p>Innehaveren betegnes "Hoppfeltleder / <i>freefall parachutist</i>".</p>'
	),
	
'309.3' => array('title' => 'FORNYELSESKRAV', 'text' => 'Som for A-sertifikat.'),

'310' => array('title' => 'C-SERTIFIKAT'),

'310.1' => array('title' => 'KVALIFIKASJONS- OG FERDIGHETSKRAV', 'text' =>
	'<p>Inneha B-sertifikat.  Fylt 18 �r. 200 godkjente fritt fall hopp.  Minst 50 formasjonshopp (FS og/eller VFS) hvor minst 10 m� ha best�tt av hhv fire (FS) eller tre (VFS) eller flere deltagere.</p><p>Mer enn 1 time akkumulert fritt fall tid.</p>'.
	'<p>Ha deltatt i minst 1 �rs praktisk (aktiv) hoppvirksomhet som selvstendig hopper. Ha gjort tjeneste som HFL minst 5 ganger. Best�tt skriftlig pr�ve overfor Instrukt�r 1 omfattende H�ndbokens del 100, 200, 300, 400 og 500. Av lokal Hovedinstrukt�r v�re funnet skikket til � fungere som Hoppleder ved treningshopping for hoppere med minimum A-sertifikat, jfr. Pkt.  310.2.</p>'
	),

'310.2' => array('title' => 'RETTIGHETER OG BEGRENSNINGER', 'text' =>
	'<p>C-sertifikat gir samme rettigheter som B-sertifikat, samt rett til � attestere alle hopplogger, dog ikke for progresjonshopp som krever attestasjon av Instrukt�r.</p>'.
	'<p>C-sertifikat gir rett til � fungere som Hoppleder ved treningshopping for hoppere med minimum A-sertifikat. </p>'.
	'<p>Innehaveren betegnes "Hoppmester / experienced parachutist".</p>'
	),

'310.3' => array('title' => 'FORNYELSESKRAV', 'text' =>
	'<p>Fornyelse av C-sertifikat krever minimum 40 hopp siste 365 dager.  Om hopperen har gjennomf�rt mer enn 20 fallskjermhopp siste 365 dager kan B-sertifikat fornyes.  C-sertifikat kan fornyes n�r hopperen har oppn�dd 40 hopp siste 365 dager. </p>'.
	'<p>Om hopperen har gjennomf�rt mindre enn 20 hopp siste 365 dager vil fornyelseskrav som for A og B sertifikat gjelde, ref pkt 308.3.</p>',
	),

'311' => array('title' => 'D-SERTIFIKAT'),

'311.1' => array('title' => 'KVALIFIKASJONS- OG FERDIGHETSKRAV', 'text' =>
	'<p>Inneha C-sertifikat og Instrukt�r 3-lisens.</p>'.
	'<p>Minst 500 godkjente fritt fall hopp.  Mer enn 3 timer akkumulert fritt fall tid.</p>'.
	'<p>Avlagt skriftlig pr�ve overfor Instrukt�r 1 omfattende H�ndbokens del 100, 200, 300, 400, 500 og 600, med vedlegg for alle kapitler. Ha teoretisk kjennskap til CF-hopping. Pr�vene skal v�re avlagt overfor Instrukt�r 1. </p>'
	),

'311.2' => array('title' => 'RETTIGHETER OG BEGRENSNINGER', 'text' =>
	'<p>D-sertifikat gir samme rettigheter som C-sertifikatet, samt rett til � godkjenne hoppfelt for egen hopping.</p>'.
	'<p>D-sertifikat gir hopperen rett til � fungere som Hoppleder ved alminnelig hopping.</p>'.
	'<p>Innehaveren betegnes "Hoppleder / senior parachutist".</p>'
	),

'312' => array('title' => 'GJENUTSTEDELSE AV A-, B-, C- ELLER D- SERTIFIKAT N�R DET ER HOPPET DE SISTE 10 �R'),

'313' => array('title' => 'VIDEOSERTIFIKAT'),

'313.1' => array('title' => 'VIDEOSERTIFIKAT TANDEM'),

'313.1.2' => array('title' => 'KVALIFIKASJONSKRAV', 'text' =>
	'<p>C-sertifikat.  Utf�rt minimum 50 hopp som fotograf for FS.  F�r kursstart skal resultatet av 20 av hoppene/ferdighetene presenteres p� DVD.</p>'.
	'<p style="color:red;">Ved kursstart skal nye kandidater presentere resultatet av 20 av disse fotohoppene for vurdering av ferdighetene til � filme p� magen i minimum 1:1 i front slik tandem vil v�re filmet.  For bedre � f� inn dette med kompetanse, ferdigheter og kunnskap skal kurset holdes av en erfaren VT hopper sammen med en I-1 som har eller har v�rt instrukt�r tandem.</p>'
	),

'314' => array('title' => 'DEMOSERTIFIKATER', 'text' => 'Demosertifikater utstedes i tre klasser.'),

'314.1' => array('title' => 'DEMOSERTIFIKAT II'),
'314.1.1' => array('title' => 'KVALIFIKASJONSKRAV', 'text' =>
	'C-sertifikat og s�rlig vurderte personlige egenskaper og dyktighet. Minimum 300 hopp.  Vurdering foretas av lokal Hovedinstrukt�r. S�rlig utsjekk p� hopp med utstyr etter Del 100. '
	),

'314.2' => array('title' => 'DEMOSERTIFIKAT I'),
'314.2.1' => array('title' => 'KVALIFIKASJONSKRAV', 'text' =>
	'D-sertifikat samt � ha deltatt i minst 10 oppvisninger. Inneha demosertifikat II. S�rlig vurderte personlige egenskaper og dyktighet. Vurdering foretas av lokal Hovedinstrukt�r.'
	),

'314.2.2' => array('title' => 'RETTIGHETER', 'text' => 'Lede gjennomf�ringen av en fallskjermoppvisning.'),
'314.2.4' => array('title' => 'VEDLIKEHOLDSKRAV', 'text' => 'Inneha gyldig D-sertfikat.'),

'314.3' => array('title' => 'DEMOSERTIFIKAT TANDEM'),
'314.3.1' => array('title' => 'KVALIFIKASJONSKRAV', 'text' =>
	'Godkjent Tandeminstrukt�r. Inneha Demosertifikat I. Ha v�rt godkjent Tandeminstrukt�r i minst 1 �r. Ha gjennomf�rt minst 200 Tandemhopp. Inneha s�rlige personlige egenskaper og dyktighet. Anbefaling gis av lokal Hovedinstrukt�r. Sikkerhets- og utdanningskommiteen vurderer og godkjenner. Avslag kan gis uten begrunnelse. '
	),

'314.3.2' => array('title' => 'RETTIGHETER', 'text' => 'Skal lede oppvisninger der Tandemhopp inng�r som en del av oppvisningen.'),
'314.3.4' => array('title' => 'VEDLIKEHOLDSKRAV', 'text' =>
	'Gyldig D-sertifikat.  Gyldig demosertifikat klasse I. Ha gjennomf�rt minst 50 tandemhopp siste 365 dager'
	),

'400' => array('title' => 'INSTRUKT�RLISENSER'),

'401' => array('title' => 'GENERELT'),

'401.2' => array('title' => 'KANDIDATER', 'text' =>
	'Sikkerhets- og Utdanningskomiteen F/NLF vurderer og tar ut instrukt�rkandidater til klasse 2 eller h�yere, etter s�knad og anbefaling fra lokalklubbens Hovedinstrukt�r. Personer som �nsker � bli antatt som kandidater leverer s�knad gjennom lokalklubbs Hovedinstrukt�r innen de tidsfrister som SU fastsetter. Instrukt�rkandidater av klasse 3 vurderes og uttas av lokalklubbens Hovedinstrukt�r.'
	),

'401.5' => array('title' => 'FORNYELSE'),

'401.5.2' => array('title' => 'INSTRUKT�R / EKSAMINATOR', 'text' =>
	'For Instrukt�r/Eksaminator gjelder ingen fornyelseskrav. SU vil benytte vedkommendes kompetanse ved behov. '),

'402' => array('title' => 'KLASSER OG BETEGNELSER'),

'402.1' => array('title' => 'INSTRUKT�R 3 (I-3)', 'text' =>
	'Instrukt�r 3 er en fallskjermhopper som innehar Instrukt�rlisens 3, og som er godkjent av Hovedinstrukt�r til � hoppmestre elever p� line, fritt fall og AFF-elever fra niv� 8, samt til � attestere alle hopplogger, dog ikke for spesielle progresjonshopp som krever godkjenning av instrukt�r av h�yere klasse. '
	),

'402.1.1' => array('title' => 'ERFARINGSKRAV', 'text' =>
	'Inneha norsk C-sertifikat. Ha gjort tjeneste som HFL ved hopping med elever minst 5 ganger. Ha v�rt hjelpeinstrukt�r p� minst 3 grunnkurs del 1 og minst 2 grunnkurs del 2.'
	),

'402.2' => array('title' => 'INSTRUKT�R 2 (I-2)'),

'402.2.1' => array('title' => 'ERFARINGSKRAV', 'text' =>
	'Ha deltatt i til sammen 2 �rs praktisk hoppvirksomhet, herav minst 12 mndr som Instrukt�r 3, og derigjennom tilegnet seg allsidig erfaring i hoppmestring av elever, samt erfaring med hoppfeltorganisasjon (HFL- tjeneste). Ha v�rt hjelpeinstrukt�r p� minst 2 komplette grunnkurs (b�de del 1 og del 2), etter utstedt Instrukt�rlisens 3. '
	),

'402.3' => array('title' => 'INSTRUKT�R 1 (I-1)'),

'402.3.1' => array('title' => 'ERFARINGSKRAV', 'text' =>
	'Ha deltatt i minst 3 �rs praktisk hoppvirksomhet, herav minst 12 mndr som I-2 og derigjennom ha tilegnet seg allsidig erfaring i grunnleggende og videreg�ende utdannelse og kontroll av elever p� alle trinn, samt erfaring som Hoppleder. Som Instrukt�r 2 ha v�rt instrukt�r ved minst 3 komplette grunnkurs frem til elevenes FF-status, dvs b�de grunnkursets del 1 og del 2. Inneha norsk D-sertifikat og Demosertifikat.'
	),


'402.3.3' => array('title' => 'RETTIGHETER OG OPPGAVER', 'text' =>
	'Etter fastlagte programmer iht Del 600 og retningslinjer gitt av lokal Hovedinstrukt�r, selvstendig legge opp, lede og gjennomf�re fallskjermkurs og videreg�ende utdannelse av hoppere frem til og med D-sertifikat. Instruere i vannhopp, natthopp og oksygenhopp, samt all annen alminnelig hopping. Instruere i CF dersom dette er gjennomf�rt selv. Undervise, kontrollere og autorisere fallskjermpakkere p� alle typer sportsskjermer som han selv er sertifisert for. V�re eksaminator og sensor ved pr�ver av alle typer og grader, unntatt F/NLFs B-kurs, C-kurs, MK-kurs, AFF-kurs og Tandemkurs. V�re HL for alle typer hopping.  Rekognosere og anbefale godkjenning av hoppfelt for alle typer hopping. Som HL godkjenne hoppfelt etter gjeldende bestemmelser.'
	),

'402.4' => array('title' => 'INSTRUKT�R TANDEM'),

'402.4.1' => array('title' => 'ERFARINGSKRAV', 'text' =>
	'<p>Inneha instrukt�rlisens 2 eller h�yere. Ha v�rt aktiv hoppmester under hopping med elever.</p>'.
	'<p>Minimum 100 hopp siste �r f�r utsjekk.</p>'.
	'<p>Under kontroll og oppf�lging fra egen Hovedinstrukt�r ha gjennomf�rt 20 utviklingshopp i l�pet av 12 m�neder, derav minst 4 hopp i l�pet av de f�rste 3 m�nedene etter gjennomf�rt Tandemhoppmesterkurs.</p>'
	),

'500' => array('title' => 'OPERATIVE BESTEMMELSER'),

'501' => array('title' => 'GENERELT', 'text' =>
	'<p>Del 500 av F/NLF Bestemmelser fastlegger forutsetningene for ut�velse av utdanning og praktisk hoppvirksomhet, og foreskriver hvordan organisering og drift skal skje. </p>'.
	'<p>Praktisk hoppvirksomhet er � forst� som all virksomhet som inkluderer utsprang fra luftfart�y i luften - elevhopping, treningshopping, konkurransehopping og alle spesielle hopptyper som oppvisnings-, natt-, vann- og oksygenhopping, etc.</p>'.
	'<p>All utdanning og praktisk hoppvirksomhet skal skje etter denne F/NLF h�ndbok som er godkjent som sikkerhetssystem etter Luftfartstilsynets BSL- D 4.2 som regulerer all sivil fallskjermhopping i Norge.</p>'.
	'<p>Del 500 beskriver dessuten det ansvar og den myndighet de enkelte ledd i den operative organisasjonen har, og gir instrukser for det operative personellet (se vedlegg 1-4).</p>'.
	'<p>Ethvert medlem som befinner seg p� hoppfeltet, plikter � rette seg etter de anvisninger som gis av ansvarlig personell. Ethvert klubbmedlem har rett og plikt til � gripe inn ved brudd p� bestemmelsene, ref Del 100 og del 200. </p>'
	),

'502' => array('title' => 'ORGANISASJON'),

'502.1' => array('title' => 'SIKKERHETS- OG UTDANNINGSKOMITEEN (SU)'),

'502.2' => array('title' => 'MATERIELLSJEFEN (MSJ)', 'text' =>
	'<p>MSJ oppnevnes av Styret F/NLF og ut�ver i samarbeid med SU overordnet kontroll med all materielltjeneste innen F/NLF. MSJ utarbeider �rlig m�lsettinger og en arbeidsplan som godkjennes av Styret F/NLF. </p>'.
	'<p style="color:red;">Med hjemmel i Bestemmelser for Sivil Luftfart (BSL) D 4-2 � 4 (2) b, utsteder, iverksetter og h�ndhever SU gjennom MSJ og F/NLFs H�ndbok Del 200 og Materiellh�ndboka, bestemmelser for F/NLFs materielltjeneste.</p>'.
	'<p>MSJ typegodkjenner alt fallskjermmateriell.</p>'
	),

'502.3' => array('title' => 'HOVEDINSTRUKT�R (HI)', 'text' =>
	'<p>Hovedinstrukt�r er den Instrukt�r som er oppnevnt av styret i klubb eller annen organisasjonsenhet til � lede all utdanning og praktisk hoppvirksomhet.  Oppnevnelsen skal godkjennes av SU. Klubbens operasjonstillatelse er avhengig av Hovedinstrukt�rens lisensklasse. Dersom spesielle grunner tilsier det, kan SU dispensere fra kravet om HI av klasse I-1 for klubber/enheter som �nsker OT-1.</p>'.
	'<p>HI har ansvaret for at all utdannelse og praktisk hopping skjer etter en plan godkjent av klubbstyret, og i henhold til de til enhver tid gjeldende bestemmelser.  Planen skal inneholde delm�l og resultatm�l, samt planer for hvordan klubbens operative drift skal koordineres, gjennomf�res og kontrolleres. Planen skal som et minimum inneholde m�lsettinger for hovedomr�dene hoppfeltdrift, utdanning, materielltjeneste, kommunikasjon og kvalitetskontroll.</p>'.
	'<p>HI organiserer og har ansvar for all praktisk hopping og utdanning som klubben har driftstillatelse for gjennom fordeling av oppgaver til sin operative stab av instrukt�rer, hoppledere, hoppmestere og hoppfeltledere, med tilfredsstillende kvalifikasjoner.</p>'.
	'<p style="color:red;">HI godkjenner hoppfelt for alminnelig hopping i henhold til klubbens operasjonstillatelse og innhenter grunneiers tillatelse, varsler politi og lufttrafikktjeneste og ivaretar koordinering mot relevant myndighet.  Godkjenning av hoppfelt for alminnelig hopping til varig bruk varsles SU som gjennom kontakt med Luftfartstilsynet p�ser at hoppfeltet opptas i AIP Norge, ENR 5.5-4 Fallskjermhopping faste steder. </p>'.
	'<p>Hovedinstrukt�ren er faglig ansvarlig for sikkerhet og materiell. Han er faglig bindeledd mellom lokalklubb og SU. </p>'.
	'<p>Hovedinstrukt�ren har ansvaret for klubbens operative arkiv, manifester, kursprotokoller, NOTAM, korrespondanse med SU og F/NLF. Han er ansvarlig for at rutinemessige rapporter som vedr�rer den operative drift blir utarbeidet og innsendt i rett tid, samt at hendelsesrapporter blir utarbeidet, kommentert og rapportert til SU v/ F/NLFs sekretariat uten un�dig opphold.</p>'
	),

'502.4' => array('title' => 'INSTRUKT�r (I)', 'text' =>
	'Instrukt�r ivaretar og utforer de oppgaver og funksjoner som etter disse bestemmelser krever instrukt�rkvalifikasjoner, med de rettigheter og begrensninger som gjelder for den enkelte lisensklasse.'
	),
	
'502.5' => array('title' => 'HOPPLEDER (HL)', 'text' =>
	'HL er den person som er overlatt ansvaret for gjennomforing av praktisk hoppvirksomhet p� ETT STED i et BESTEMT TIDSROM.  HL skal v�re utpekt f�r hopping startes av lokal HI.  HL skal folge Hopplederinstruksen, se vedlegg 1 til del 500.'
	),
	
'502.6' => array('title' => 'HOPPFELTLEDER (HFL)', 'text' =>
	'HFL utpekes av HL, er underlagt denne, og har til oppgave � administrere, organisere og overv�ke hoppfeltet, og p�se at hoppingen gjennomf�res etter gjeldende bestemmelser. HFL skal f�lge Hoppfeltlederinstruks, se vedlegg 2 til del 500.'
	),

'502.10' => array('title' => 'KOMBINASJON AV FUNKSJONER ', 'text' =>
	'<p>HFL tillates ikke � hoppe, og skal under hopping til enhver tid v�re tilstede p� hoppfeltet. Funksjonen som HL kan kombineres med funksjon som HFL, HM eller Flyger.</p>'.
	'<p>HL kan dersom aktiviteten krever det utpeke flere HFL-er, som skal virke sammen. HL har ansvar for oppgavefordelingen mellom disse.</p>'
	),

'503' => array('title' => 'OPERASJONSTILLATELSER'),

'503.2' => array('title' => 'OPERASJONSTILLATELSE KLASSE 2 (OT 2)', 'text' =>
	'<p>Organisasjon som innehar OT 2 kan organisere og gjennomf�re fallskjermhopping for hoppere med A-sertifikat og h�yere, innenfor et bestemt geografisk omr�de, men ikke teoretisk eller praktisk utdanning i fallskjermhopping som definert i Del 600, eller spesielle hopptyper som definert i Del 100.</p>'.
	'<p>OT 2 utstedes til klubber eller organisasjoner som kan dokumentere at de tilfredsstiller f�lgende krav: </p>'.
	'<ul>'.
	'<li>For klubber: Er opptatt b�de i NLF/NAK.</li>'.
	'<li>For driftsorganisasjoner: Er godkjent av F/NLF.</li>'.
	'<li>Har Hovedinstrukt�r klasse I/2 godkjent av SU.</li>'.
	'<li>Disponerer hoppfelt iht Del 100.</li>'.
	'</ul>'
	),

'504' => array('title' => 'KLARERING AV AKTIVITET - NOTAM'),

'504.2' => array('title' => 'NOTAM', 'text' =>
	'<p>For fallskjermhopping utenfor omr�der med obligatorisk radiosamband med flygekontrolltjenestens enheter, som enten kan sies � v�re;</p>'.
	'<ol>'.
	'<li>av st�rre omfang og vil foreg� utenfor kunngjorte, faste hoppfelt, eller</li>'.
	'<li>vil foreg� om natten,</li>'.
	'</ol>'.
	'<p>skal det sendes inn NOTAM i h.t. pkt 504.2.1.</p>'.
	'<p>Som hopping av st�rre omfang menes mer enn 20 hopp per dropp, mer enn 100 hopp totalt og/eller aktivitet utover 24 timer.</p>'
	),

'505' => array('title' => 'HANDLINGSINSTRUKS VED ULYKKE'),

'505.1' => array('title' => 'PRIORITERTE TILTAK', 'text' =>
	'<table>'.
	'<tr><td>0.</td><td>Start f�rstehjelp.</td><td>&nbsp;</td></tr>'.
	'<tr><td>1.</td><td>Tilkall lege:</td><td>tlfnr:....................</td></tr>'.
	'<tr><td>2.</td><td>Tilkall politi:</td><td>tlfnr:....................</td></tr>'.
	'<tr><td>3.</td><td>Varsle Flygekontrollenhet:</td><td>tlfnr:....................</td></tr>'.
	'<tr><td>4.</td><td>Varsle F/NLFs sentrale organisasjon v/Fagsjef:</td><td>tlfnr:....................</td></tr>'.
	'<tr><td>&nbsp;</td><td>evt. Leder F/NLF:</td><td>tlfnr:....................</td></tr>'.
	'<tr><td>&nbsp;</td><td>evt. Leder SU:</td><td>tlfnr:...................</td></tr>'.
	'<tr><td>&nbsp;</td><td>som vil s�rge for at sentrale tiltak iverksettes.</td></td>&nbsp;<td></tr>'.
	'<tr><td>5.</td><td>Varsle egen Hovedinstrukt�r:</td><td>tlfnr:....................</td></tr>'.
	'</table>'.
	'<p>NB! Det er politiets ansvar � underrette forulykkedes p�r�rende.</p>'
	),

'505.2' => array('title' => 'FORHOLD TIL PRESSE/MEDIA', 'text' =>
	'<p>Avst� fra intervju p� ulykkesdagen. Bruk om n�dvendig denne standarduttalelse:</p>'.
	'<ul><li>"Ulykken vil bli etterforsket av politiet og av kommisjon fra Norges Luftsportsforbund. Vi avst�r fra � kommentere �rsaksforholdet inntil kommisjonens rapport foreligger."</li></ul>'.
	'<p>NB! Oppgi IKKE forulykkedes navn eller andre personalia. Det er politiets ansvar. </p>'.
	'<p>Pass p� at andre p� feltet ikke kommer med egne uttalelser som er i strid med de ovenst�ende retningslinjer.</p>'.
	'<p>Ved s�rlig p�g�ende pressefolk:</p>'.
	'<p>Gj�r disse oppmerksom p� "v�r varsom"-paragrafen som er trykket p� deres eget pressekort. Der st�r det blant annet:</p>'.
	'<ul><li>"Vis s�rlig hensyn overfor personer som ikke kan ventes � v�re klar over bivirkningen av sine uttalelser. Misbruk ikke andres f�lelser, uvitenhet eller sviktende d�mmekraft." </li></ul>'
	),

'506' => array('title' => 'HOPPLEDERINSTRUKS'),

'506.2' => array('title' => 'KVALIFIKASJONER', 'text' =>
	'<p>Som tilstrekkelig kvalifikasjon for HL regnes:</p>'.
	'<ul>'.
	'<li>For hopping med hoppere med A-sertifikat og h�yere: C-sertifikat </li>'.
	'<li>Ved hopping med elever: D-sertifikat eller Instrukt�r 2. <p style="color:red;">HI kan unntaksvis og etter s�rskilt vurdering for elevhopping godkjenne HL med C sert og I-3 n�r vedkommende minimum har 2 �rs erfaring som I-3, har deltatt jevnlig i klubbens utdanningsvirksomhet og operative drift i tillegg til � ha inng�ende lokalkunnskaper. Dette gjelder kun ved hopping fra fly med maks 6 hoppere og kun ved dropp fra et fly. Godkjente HL-er ihht dette, skal framkomme i HIs plan</p></li>'.
	'<li>Ved natt-, vann- og oksygenhopping med personell som ikke har utf�rt slike hopp tidligere:  Instrukt�r 1</li>'.
	'<li>Ved natt-, vann- og oksygenhopping med personell som har utf�rt slike hopp tidligere:  D-sertifikat eller Instrukt�r 2 </li>'.
	'</ul>'
	),

'506.6' => array('title' => 'ANDRE FORHOLD'),

'506.6.2' => array('title' => 'DELTAGELSE I HOPPING', 'text' =>
	'HL kan under sin tjeneste v�re p� bakken eller i luften og delta aktivt i hoppingen, dog p� en slik m�te at han hele tiden har kontroll med virksomheten.'
	),

'507' => array('title' => 'HOPPFELTLEDERINSTRUKS'),

'507.2' => array('title' => 'KVALIFIKASJONER', 'text' =>
	'<p>Som tilstrekkelig kvalifikasjon for HFL regnes: </p>'.
	'<p>Ved hopping med elever:</p>'.
	'<ul><li>Fallskjermhoppere med B-sertifikat eller h�yere, eller personell som etter HLs vurdering antas � v�re spesielt kvalifisert gjennom inng�ende praktisk erfaring under elevhopping. </li></ul>'.
	'<p>Ved hopping med hoppere med A-sertifikat eller h�yere:</p>'.
	'<ul><li>Personell som p� forh�nd er instruert av HL om de oppgaver som p�ligger HFL.</li></ul>'.
	'<p>Ved natthopp, vannhopp og oksygenhopp: </p>'.
	'<ul><li>Hopper med Instrukt�rlisens 3 eller h�yere</li></ul>'
	),

'508' => array('title' => 'HOPPMESTERINSTRUKS'),

'508.2' => array('title' => 'KVALIFIKASJONER', 'text' =>
	'<p>Som tilstrekkelig kvalifikasjon for HM regnes:</p>'.
	'<ul>'.
	'<li>N�r alle ombordv�rende hoppere har A-sertifikat eller h�yere: Hoppere med B-sertifikat </li>'.
	'<li>N�r det blant de ombordv�rende hoppere er line, eller FF elever: Instrukt�r 3</li>'.
	'<li>For AFF-elever p� niv� 1-7:  Instrukt�r 3-AFF</li>'.
	'<li>Dersom utsprang inneb�rer natthopp: Hopper med D-sertifikat, som har gjennomf�rt natthopp tidligere, eller hopper med instrukt�rlisens klasse 2 eller h�yere</li>'.
	'<li>Dersom utsprang inneb�rer oppvisningshopp: Tilfredsstille krav som angitt under F/NLFs bestemmelser Del 300</li>'.
	'</ul>'
	),

'508.3' => array('title' => 'ANSVAR', 'text' =>
	'<p>HM er ansvarlig for hopperne i sitt l�ft, og har ansvaret overfor Flyger for at dennes anvisninger blir fulgt.</p>'.
	'<p>HM har ansvaret for at de utsprang som utf�res under hans kommando skjer i overensstemmelse med F/NLFs bestemmelser Del 100.</p>'.
	'<p>Der jordtegn anvendes som signalsystem er HM ansvarlig for at utsprang ikke foretas dersom jordtegn er fjernet eller slik plassert at det m� forst�s at utsprang ikke skal finne sted.</p>'.
	'<p>Er jordtegn eneste kommunikasjon bakke/fly skal HM p�se at utsprang ikke gjennomf�res uten at jordtegn er synlige fra flyet.</p>'.
	'<p>Anvendes annet kommunikasjonssystem enn jordtegn, har HM ansvaret for at ordrer fra bakken f�lges.</p>'
	),

'600' => array('title' => 'PROGRAM FOR STANDARDISERT GRUNNOPPL�RING I FALLSKJERMHOPPING'),

'603' => array('title' => 'PROGRESJONSPLAN'),

'603.3' => array('title' => 'HOPP MED FRITT FALL OG MANUELT UTL�ST FALLSKJERM'),

'603.3.1' => array('title' => 'FARLIG/UKONTROLLERT HOPPING OG VURDERING AV PERMANENT HOPPFORBUD', 'text' =>
	'<p>F�lgende kriterer er faste normer for kjennelse "Farlig/Ukontrollert" hopping:</p>'.
	'<ul>'.
	'<li>Fosterstilling gjennom hele fallet.</li>'.
	'<li>Tumbling (kraftig rotasjon i flere plan) i fallet og i trekket.</li>'.
	'<li>Feil eller manglende n�dprosedyre.</li>'.
	'<li>Direkte trekk uten cutaway ved feilfunksjon av hovedskjerm.</li>'.
	'<li>Ikke fullf�rt n�dprosedyre.</li>'.
	'<li>Cutaway under to �pne skjermer &mdash; med mindre disse flyr "downplane".</li>'.
	'<li>Berget av n�d�pner p� grunn av manglende trekk.</li>'.
	'<li>Panikkartet/ukontrollert atferd i flyet.</li>'.
	'<li>Ukontrollert skjermkj�ring.</li>'.
	'</ul>'.
	'<p>Foranst�ende betraktes som klare kriterier for at Hoppmester gir karakter "FU" ved bed�mmelse av hoppet. Eleven skal gj�res kjent med kjennelsen, og den videre saksbehandling. HM skal, i samr�d med Hoppleder, p�legge eleven ytterligere trening med instrukt�r f�r hopping kan fortsette. Eleven skal vurderes tilbakef�rt i progresjonen.</p>'.
	'<p>Hendelsesrapportskjema fylles ut, med n�yaktig angivelse av hendelsesforl�p og �rsak til kjennelsen. Dersom HM finner at ogs� tidligere hopp er karakterisert som FU, eller hvis FU-kjennelsen er gitt p� grunn av manglende trekk, slik at eleven ble berget av n�d�pneren, skal eleven gis midlertidig hoppforbud inntil Hovedinstrukt�ren har gitt sin totalvurdering.</p>'.
	'<p>Hovedinstrukt�ren vurderer om spesielle treningsformer, og/eller s�rlig oppf�lging skal iverksettes, slik at eleven oppn�r de n�dvendige ferdigheter som kreves for sikkerhetsmessig forsvarlig fortsettelse av hoppingen. Dersom dette ikke ansees mulig eller forsvarlig skal eleven nektes all videre hopping. Eventuelt vedtak om permanent hoppforbud fattes av Hovedinstrukt�r. Vedtak f�res i elevens hopplogg, ved det hoppet som f�rte til avgj�relsen, og p� den siden som inneholder hopperens personalia, navn og foto. Avgj�relse rapporteres til SU p� hendelsesrapportskjema.</p>'
	),

);

?>
