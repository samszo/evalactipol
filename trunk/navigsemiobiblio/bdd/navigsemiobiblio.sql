-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Samedi 20 Décembre 2008 à 01:18
-- Version du serveur: 5.0.27
-- Version de PHP: 5.2.0
-- 
-- Base de données: `navigsemiobiblio`
-- 
CREATE DATABASE `navigsemiobiblio` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `navigsemiobiblio`;

-- --------------------------------------------------------

-- 
-- Structure de la table `dico`
-- 

CREATE TABLE `dico` (
  `id_dico` int(11) NOT NULL auto_increment,
  `cdu` varchar(255) NOT NULL,
  `timeline` text NOT NULL,
  `kml` text NOT NULL,
  `ieml` text NOT NULL,
  PRIMARY KEY  (`id_dico`),
  KEY `cdu` (`cdu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Contenu de la table `dico`
-- 

INSERT INTO `dico` (`id_dico`, `cdu`, `timeline`, `kml`, `ieml`) VALUES 
(1, '1"04/14"(4)', '<data \r\n  wiki-url="http://simile.mit.edu/shelf/" \r\n  wiki-section="Simile JFK Timeline">\r\n    <event \r\n       start="Sat May 20 1961 00:00:00 GMT-0600" \r\n       title="''Bay of Pigs'' Invasion">\r\n    </event>\r\n    <event \r\n       start="Wed May 01 1963 00:00:00 GMT-0600" \r\n       end="Sat Jun 01 1963 00:00:00 GMT-0600" \r\n       isDuration="true" \r\n       title="Oswald moves to New Orleans">\r\n         Oswald moves to New Orleans, and finds employment at the William <!-- The event''s description -->\r\n         B. Riley Coffee Company. &lt;i&gt;ref. Treachery in Dallas, p 320&lt;/i&gt;\r\n    </event>\r\n    <event>\r\n      ...\r\n    </event>\r\n</data>', '<kml xmlns="http://earth.google.com/kml/2.2">\r\n<Document>\r\n  <name>bonheur</name>\r\n  <description><![CDATA[]]></description>\r\n  <NetworkLink>\r\n    <name>bonheur</name>\r\n    <Link>\r\n      <href>http://maps.google.fr/maps/ms?ie=UTF8&amp;oe=UTF8&amp;client=firefox-a&amp;hl=fr&amp;msa=0&amp;msid=100465490699925131471.00045b69eb413f8cb489b&amp;output=kml</href>\r\n    </Link>\r\n  </NetworkLink>\r\n</Document>\r\n</kml>', '/(S:|U:|A:)/(wu.|l.|k.|t.|n.)/(t.o.-)'),
(2, '61(091)', '<data \r\n  wiki-url="http://simile.mit.edu/shelf/" \r\n  wiki-section="Simile JFK Timeline">\r\n    <event \r\n       start="Sat May 20 1961 00:00:00 GMT-0600" \r\n       title="''Bay of Pigs'' Invasion">\r\n    </event>\r\n    <event \r\n       start="Wed May 01 1963 00:00:00 GMT-0600" \r\n       end="Sat Jun 01 1963 00:00:00 GMT-0600" \r\n       isDuration="true" \r\n       title="Oswald moves to New Orleans">\r\n         Oswald moves to New Orleans, and finds employment at the William <!-- The event''s description -->\r\n         B. Riley Coffee Company. &lt;i&gt;ref. Treachery in Dallas, p 320&lt;/i&gt;\r\n    </event>\r\n    <event>\r\n      ...\r\n    </event>\r\n</data>', '<kml xmlns="http://earth.google.com/kml/2.2">\r\n<Document>\r\n	<name>bonbonheur.kml</name>\r\n	<Style id="sh_ylw-pushpin">\r\n		<IconStyle>\r\n			<scale>1.3</scale>\r\n			<Icon>\r\n				<href>http://maps.google.com/mapfiles/kml/pushpin/ylw-pushpin.png</href>\r\n			</Icon>\r\n			<hotSpot x="20" y="2" xunits="pixels" yunits="pixels"/>\r\n		</IconStyle>\r\n		<LineStyle>\r\n			<color>ff7faa00</color>\r\n			<width>30</width>\r\n		</LineStyle>\r\n		<PolyStyle>\r\n			<color>ff00aa00</color>\r\n		</PolyStyle>\r\n	</Style>\r\n	<Style id="sh_sunny">\r\n		<IconStyle>\r\n			<scale>1.4</scale>\r\n			<Icon>\r\n				<href>http://maps.google.com/mapfiles/kml/shapes/sunny.png</href>\r\n			</Icon>\r\n			<hotSpot x="0.5" y="0" xunits="fraction" yunits="fraction"/>\r\n		</IconStyle>\r\n		<ListStyle>\r\n		</ListStyle>\r\n	</Style>\r\n	<Style id="sn_ylw-pushpin">\r\n		<IconStyle>\r\n			<scale>1.1</scale>\r\n			<Icon>\r\n				<href>http://maps.google.com/mapfiles/kml/pushpin/ylw-pushpin.png</href>\r\n			</Icon>\r\n			<hotSpot x="20" y="2" xunits="pixels" yunits="pixels"/>\r\n		</IconStyle>\r\n		<LineStyle>\r\n			<color>ff7faa00</color>\r\n			<width>30</width>\r\n		</LineStyle>\r\n		<PolyStyle>\r\n			<color>ff00aa00</color>\r\n		</PolyStyle>\r\n	</Style>\r\n	<Style id="sn_sunny">\r\n		<IconStyle>\r\n			<scale>1.2</scale>\r\n			<Icon>\r\n				<href>http://maps.google.com/mapfiles/kml/shapes/sunny.png</href>\r\n			</Icon>\r\n			<hotSpot x="0.5" y="0" xunits="fraction" yunits="fraction"/>\r\n		</IconStyle>\r\n		<ListStyle>\r\n		</ListStyle>\r\n	</Style>\r\n	<StyleMap id="msn_sunny">\r\n		<Pair>\r\n			<key>normal</key>\r\n			<styleUrl>#sn_sunny</styleUrl>\r\n		</Pair>\r\n		<Pair>\r\n			<key>highlight</key>\r\n			<styleUrl>#sh_sunny</styleUrl>\r\n		</Pair>\r\n	</StyleMap>\r\n	<StyleMap id="msn_ylw-pushpin">\r\n		<Pair>\r\n			<key>normal</key>\r\n			<styleUrl>#sn_ylw-pushpin</styleUrl>\r\n		</Pair>\r\n		<Pair>\r\n			<key>highlight</key>\r\n			<styleUrl>#sh_ylw-pushpin</styleUrl>\r\n		</Pair>\r\n	</StyleMap>\r\n	<Folder>\r\n		<name>bonheur</name>\r\n		<open>1</open>\r\n		<Placemark>\r\n			<name>il est passé par ici</name>\r\n			<LookAt>\r\n				<longitude>-91.33333599999996</longitude>\r\n				<latitude>49.30583000000001</latitude>\r\n				<altitude>0</altitude>\r\n				<range>1905.145556855214</range>\r\n				<tilt>0</tilt>\r\n				<heading>1.631817376590409e-014</heading>\r\n				<altitudeMode>relativeToGround</altitudeMode>\r\n			</LookAt>\r\n			<styleUrl>#msn_sunny</styleUrl>\r\n			<Point>\r\n				<coordinates>-91.33529050112915,49.30397185356222,0</coordinates>\r\n			</Point>\r\n		</Placemark>\r\n		<Placemark>\r\n			<name>il a agit jusqu&apos;ici</name>\r\n			<styleUrl>#msn_ylw-pushpin</styleUrl>\r\n			<Polygon>\r\n				<tessellate>1</tessellate>\r\n				<outerBoundaryIs>\r\n					<LinearRing>\r\n						<coordinates>\r\n-91.33239289164871,49.30609353442484,0 -91.32910784781927,49.30776258467262,0 -91.32916639489713,49.30786148326786,0 -91.3293422216356,49.30817835563151,0 -91.32946146409921,49.30833642897858,0 -91.32964161089357,49.3085335710406,0 -91.32982254936773,49.30869088073373,0 -91.33006506814178,49.30882737015524,0 -91.33039686108597,49.30894511639202,0 -91.3307884579127,49.30904374750453,0 -91.33117975235788,49.30904470442848,0 -91.33154201010891,49.30904404281403,0 -91.33184388918775,49.30904325501612,0 -91.33223591935584,49.30904278691942,0 -91.33259752058395,49.30902345518766,0 -91.33307977531594,49.30896469979886,0 -91.33407459764246,49.30888637700005,0 -91.334406153481,49.30884689846037,0 -91.33585199465436,49.30866872631371,0 -91.33636401291368,49.30853100803635,0 -91.33696634044196,49.30839330532319,0 -91.33796047505378,49.3080396854976,0 -91.33826139785312,49.30786275681325,0 -91.33856120855832,49.30772474008676,0 -91.33874096323655,49.30758697908133,0 -91.33916177968023,49.30733155163334,0 -91.33961268827814,49.30709583287843,0 -91.33997182465835,49.30682071058076,0 -91.34020724226666,49.30638858990874,0 -91.34042362008455,49.30576139147508,0 -91.34041948268794,49.30560520026097,0 -91.34041362072713,49.30533220314305,0 -91.34031671839222,49.30500132958324,0 -91.3402502902385,49.30469053137244,0 -91.34015701030195,49.30451596498306,0 -91.34006101286434,49.30420609356229,0 -91.33993641377688,49.30391594340199,0 -91.33990642490076,49.30379941778175,0 -91.33966247581938,49.30349059889378,0 -91.33948323057545,49.30331613693515,0 -91.33906549759867,49.30310309257433,0 -91.33885707285988,49.30306432492142,0 -91.33835091246084,49.30296741095671,0 -91.33790413481185,49.30285120866836,0 -91.33775541670734,49.30281234445862,0 -91.33715867858381,49.30271658012737,0 -91.33700920450792,49.3027172034171,0 -91.33665076513989,49.30267987749373,0 -91.33632249700332,49.30264245076494,0 -91.33581559942296,49.3026253035339,0 -91.33509973726952,49.30263105321633,0 -91.3348320677847,49.30263294931066,0 -91.33417948105411,49.3027133154342,0 -91.333853898331,49.30275208232234,0 -91.33343957663784,49.30281004805939,0 -91.33299564402257,49.30300278787352,0 -91.33272908963046,49.30307912623778,0 -91.33219484962633,49.3032498273103,0 -91.33189656025617,49.30338191179393,0 -91.33092692831281,49.30535191534589,0 -91.33239289164871,49.30609353442484,0 </coordinates>\r\n					</LinearRing>\r\n				</outerBoundaryIs>\r\n			</Polygon>\r\n		</Placemark>\r\n	</Folder>\r\n</Document>\r\n</kml>', '/(U:)/(e.e.-d.o.-s.y.-'')'),
(3, '70(050) ', '<data\r\n wiki-url="http://simile.mit.edu/shelf1111/" >', '<kml xmlns="http://yahoo.com/kml/2.2">', '<Do... 	/(AAAAAA:)/(e.e.-d.o.-s.y.-'')>');

-- --------------------------------------------------------

-- 
-- Structure de la table `docu`
-- 

CREATE TABLE `docu` (
  `serial` int(11) NOT NULL auto_increment,
  `dc_title` varchar(255) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `enterdate` datetime NOT NULL,
  `oai_identifier` varchar(255) NOT NULL,
  `oai_set` varchar(255) NOT NULL,
  `datestamp` datetime NOT NULL,
  `deleted` enum('false','true') NOT NULL,
  `dc_creator` text NOT NULL,
  `dc_subject` varchar(255) NOT NULL,
  `dc_description` text NOT NULL,
  `dc_contributor` varchar(255) NOT NULL,
  `dc_publisher` varchar(255) NOT NULL,
  `dc_date` date NOT NULL,
  `dc_type` varchar(255) NOT NULL,
  `dc_format` varchar(255) NOT NULL,
  `dc_identifier` varchar(255) NOT NULL,
  `dc_source` varchar(255) NOT NULL,
  `dc_language` varchar(255) NOT NULL,
  `dc_relation` varchar(255) NOT NULL,
  `dc_coverage` varchar(255) NOT NULL,
  `dc_rights` varchar(255) NOT NULL,
  PRIMARY KEY  (`serial`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Contenu de la table `docu`
-- 

INSERT INTO `docu` (`serial`, `dc_title`, `provider`, `url`, `enterdate`, `oai_identifier`, `oai_set`, `datestamp`, `deleted`, `dc_creator`, `dc_subject`, `dc_description`, `dc_contributor`, `dc_publisher`, `dc_date`, `dc_type`, `dc_format`, `dc_identifier`, `dc_source`, `dc_language`, `dc_relation`, `dc_coverage`, `dc_rights`) VALUES 
(1, 'Using Structural Metadata to Localize Experience of Digital Content', 'Bibliothèque Paris8', 'http://www.bu.univ-paris8.fr/philosophie', '2008-12-02 15:54:47', 'OAIBUP8', 'philosophie', '2008-12-04 15:52:12', 'false', 'Dushay, Naomi', '1"04/14"(4)', 'With the increasing technical sophistication of both information consumers and providers, there is increasing demand for more meaningful experiences of digital information. We present a framework that separates digital object experience, or rendering, from digital object storage and manipulation, so the rendering can be tailored to particular communities of users.', 'Dushay, Naomi', 'Bibliothèque Paris8', '2001-12-14', 'e-print', 'text/xml', 'oai:OAIBUP8:1"04/14"(4)', 'Shakespeare''s Romeo and Juliet', 'en', 'Shakespeare''s Romeo and Juliet', 'US civil war era; 1861-1865', 'Access limited to members.'),
(2, 'Methods of Information in Medicine, Vol 32, No 4', 'Bibliothèque Paris8', 'http://www.bu.univ-paris8.fr/medecine', '2008-12-03 02:16:40', 'OAIBUP8', 'medecine', '2008-12-02 02:17:19', 'false', 'Paster', '61(091)', 'Les systèmes d informations appliquées à la medecine', 'Faculté de medecine ', 'Moguls Anonymous', '2008-12-04', 'text', 'text/xml', 'oai:OAIBUP8:61(091)', 'Monsieur Paster', 'en', 'Histoire de la medecine', 'Recherches du 19 siècle', 'Access limited to members.');

-- --------------------------------------------------------

-- 
-- Structure de la table `documents`
-- 

CREATE TABLE `documents` (
  `serial` int(11) NOT NULL auto_increment,
  `dc_title` varchar(255) NOT NULL,
  `cdu` varchar(255) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `enterdate` datetime NOT NULL,
  `oai_identifier` varchar(255) NOT NULL,
  `oai_set` varchar(255) NOT NULL,
  `datestamp` datetime NOT NULL,
  `deleted` enum('false','true') NOT NULL,
  `dc_creator` text NOT NULL,
  `dc_subject` varchar(255) NOT NULL,
  `dc_description` text NOT NULL,
  `dc_contributor` varchar(255) NOT NULL,
  `dc_publisher` varchar(255) NOT NULL,
  `dc_date` date NOT NULL,
  `dc_type` varchar(255) NOT NULL,
  `dc_format` varchar(255) NOT NULL,
  `dc_identifier` varchar(255) NOT NULL,
  `dc_source` varchar(255) NOT NULL,
  `dc_language` varchar(255) NOT NULL,
  `dc_relation` varchar(255) NOT NULL,
  `dc_coverage` varchar(255) NOT NULL,
  `dc_rights` varchar(255) NOT NULL,
  PRIMARY KEY  (`serial`),
  KEY `cdu` (`cdu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Contenu de la table `documents`
-- 

INSERT INTO `documents` (`serial`, `dc_title`, `cdu`, `provider`, `url`, `enterdate`, `oai_identifier`, `oai_set`, `datestamp`, `deleted`, `dc_creator`, `dc_subject`, `dc_description`, `dc_contributor`, `dc_publisher`, `dc_date`, `dc_type`, `dc_format`, `dc_identifier`, `dc_source`, `dc_language`, `dc_relation`, `dc_coverage`, `dc_rights`) VALUES 
(1, 'Using Structural Metadata to Localize Experience of Digital Content', '1"04/14"(4)', 'Bibliothèque Paris8', 'http://www.bu.univ-paris8.fr/philosophie', '2008-12-02 15:54:47', 'org-OAIBUP8.org', 'philosophie', '2008-12-04 15:52:12', 'false', 'Dushay, Naomi', 'Digital Libraries', 'With the increasing technical sophistication of both information consumers and providers, there is increasing demand for more meaningful experiences of digital information. We present a framework that separates digital object experience, or rendering, from digital object storage and manipulation, so the rendering can be tailored to particular communities of users.', 'Dushay, Naomi', 'Bibliothèque Paris8', '2001-12-14', 'e-print', 'text/xml', 'http://127.0.0.1/navigsemiobiblio/library/php/oai/oai2.php', 'Shakespeare''s Romeo and Juliet', 'en', 'Shakespeare''s Romeo and Juliet', 'US civil war era; 1861-1865', 'Access limited to members.'),
(2, 'Methods of Information in Medicine, Vol 32, No 4', '61(091)', 'Bibliothèque Paris8', 'http://www.bu.univ-paris8.fr/medecine', '2008-12-03 02:16:40', 'org-OAIBUP8.org', 'medecine', '2008-12-02 02:17:19', 'false', 'Paster', 'Informations sur la medecine', 'Les systèmes d informations appliquées à la medecine', 'Faculté de medecine ', 'Moguls Anonymous', '2008-12-04', 'text', 'text/xml', 'http://127.0.0.1/navigsemiobiblio/library/php/oai/oai2.php', 'Monsieur Paster', 'en', 'Histoire de la medecine', 'Recherches du 19 siècle', 'Access limited to members.');
