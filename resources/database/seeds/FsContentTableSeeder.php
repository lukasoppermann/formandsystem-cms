<?php
use Illuminate\Database\Seeder;

class FsContentTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('fs_content')->truncate();

		\DB::table('fs_content')->insert(array (
			0 =>
			array (
				'id' => 1,
				'article_id' => 1,
				'menu_label' => 'Home',
				'link' => 'home',
				'published' => 1,
				'language' => 'de',
				'data' => '[
						{
							"class": "section-01",
							"fragment": 1
						},
						{
								"class": "space-bottom-wide",
								"link": "Vision",
								"fragment": 1
							}
				]',
				'created_at' => date("Y-m-d h:i:s"),
				'updated_at' => date("Y-m-d h:i:s"),

			),
			1 =>
			array (
				'id' => 2,
				'article_id' => 2,
				'menu_label' => 'Produkt',
				'link' => 'produkt',
				'published' => 1,
				'language' => 'de',
				'data' => '[
					{
						"class": "section-01",
						"content": [
							{
								"type": "block",
								"column": 12,
								"media": [
									{
										"src": "product.jpg",
										"description": "Qualit&#228;t und Service aus Deutschland"
									}
								],
								"content": "#Qualit&#228;t und Service aus Deutschland\\nEntwickelt in enger Zusammenarbeit mit Krankenhäusern und Universitätskliniken",
								"class": "banner js-banner"
							}
						]
					},
					{
						"class": "section-02",
						"link": "Ärzte",
						"content": [
							{
								"type": "block",
								"column": 4,
								"media": [
									{
										"src": "icon-doctor.svg",
										"description": "Vorteile für Ärzte"
									}
								],
								"content": "###Das wichtigste im Überblick\\n- Übersicht über alle relevanten Daten\n- Sämtliche Befunde auf einen Blick\n- Schnelle Eingabe ärztlicher Anordnungen\n- Die Krankengeschichte auf Abruf\n\n",
								"class": "circle-icon rounded-block rounded-block--red"
							},
							{
								"type": "block",
								"column": 7,
								"content": "##Ärzte\\nCOPRA bietet Ärzten eine Übersicht aller relevanten Behandlungsdaten innerhalb eines Programms.\\n\\nCOPRA vereinfacht notwendige Dokumentationen und macht sie für das gesamte medizinische Personal transparent. Kontextwechsel und wiederholte Anmeldungen an verschiedene Systeme werden auf ein absolutes Minimum reduziert. Als integrierter Bestandteil der Softwarelandschaft in einem Klinikum können alle Befunde des Patienten in COPRA eingesehen werden. Laborwerte werden in Copra angezeigt und können durch den Anwender mit weiteren Patientendaten in Relation gesetzt werden. COPRA ermöglicht darüber hinaus die einfache Beauftragung von Befunden. Sämtliche Befunde, die bei einem Stationsaufenthalt in COPRA dokumentiert wurden, werden am Ende der Behandlung durch COPRA bereitgestellt.\\n\\nNeben dem Überblick über alle relevanten Daten einer Behandlung werden mit COPRA auch ärztliche Anordnungen, wie zum Beispiel Medikamentenverordnungen dokumentiert und freigeschaltet. Dabei werden die Ansichten für Pfleger und Ärzte getrennt dargestellt. Ärztliche Anordnungen werden erst ab Freigabe sichtbar. So kann ein Therapieplan mit mehreren Medikamenten zunächst geplant und anschließend mit einem Klick für die Pflege bereitgestellt werden.\\n\\nDurch die “Lebensakte” eines Patienten in COPRA wird der gesamte Behandlungsverlauf, auch über einen Zeitraum von 10 Jahren hinweg, ersichtlich. Beginnend mit den Informationen des letzten Stationsaufenthalts, bis hin zu einem Vorfall vor mehreren Jahren.\\n\\nDie Darstellung und Auswahl der Informationen, die in der Patientenakte dargestellt werden, richten sich nach den individuellen Ansprüchen der medizinischen Fachgebiete und Berufsgruppen.\\n\\nCOPRA6 ist auf kurze Antwortzeiten optimiert und lässt den Arzt nicht warten.",
								"class": "prepend-1 prominent-headline prominent-headline--red"
							}
						]
					},
					{
						"class": "spacing-top",
						"link": "Pflege",
						"content": [
							{
								"type": "block",
								"column": 8,
								"content": "##Pflege\\nAlle ärztlichen Anweisungen zur Behandlung eines Patienten werden an zentraler Stelle aufgeführt. In COPRA ist immer erkennbar, welche Behandlungsschritte bereits erfolgt sind und welche nicht (Arbeitslisten). Aktivitäten, die auf Zuruf durchgeführt wurden und der Anordnung eines Arztes bedürfen, werden zum Zeitpunkt der Dokumentation dem Arzt zur Nachverordnung angezeigt.\\n\\nDie bettseitige elektronische Patientenakte ist unabhängig von der Erreichbarkeit des Kliniknetzwerks jederzeit für die Dokumentation verfügbar. Somit werden alle Maßnahmen jederzeit am Bettplatz oder auf dem mobilen Visitenwagen dokumentiert.\\n\\nDie automatische Übernahme von Gerätewerten aller am Patienten angeschlossenen Geräte erspart das manuelle Dokumentieren der Medikamentengaben durch Perfusoren oder die Aufzeichnung der Vitalparameterkurven. Die Werte müssen lediglich einmal durch das Personal geprüft und mit einem Klick bestätigt werden.\\n\\nUm alle abrechnungsrelevanten Daten zu erfassen, werden sämtliche pflegerischen Leistungen in COPRA dokumentiert und am Ende der Behandlung exportiert.",
								"class": "append-1 prominent-headline prominent-headline--red"
							},
							{
								"type": "block",
								"column": 4,
								"media": [
									{
										"src": "icon-nurse.svg",
										"description": "Vorteile für die Pflege"
									}
								],
								"content": "###Das wichtigste im Überblick\\n- Ärztliche Anweisungen zentral dargestellt\n- Jederzeit verfügbare Informationen\n- Automatische Datenübernahme\n- Dokumentation der pflegerischen Leistungen\n\n",
								"class": "circle-icon rounded-block rounded-block--red"
							}
						]
					},
					{
						"class": "spacing-top",
						"link": "Controlling",
						"content": [
							{
								"type": "block",
								"column": 4,
								"media": [
									{
										"src": "icon-controlling.svg",
										"description": "Vorteile für das Controlling"
									}
								],
								"content": "###Das wichtigste im Überblick\\n- Überblick über alle Behandlungsschritte\n- Controllingberichte\n- Vollständigkeitsprüfungen\n- Freigabe der Dokumentation\n\n",
								"class": "circle-icon rounded-block rounded-block--red"
							},
							{
								"type": "block",
								"column": 7,
								"content": "##Controlling\\nDie in COPRA dokumentierten Aktivitäten werden für die Abrechnung gesammelt und exportiert. Dadurch können erlösrelevante Therapieverfahren und Maßnahmen ohne das manuelle Durchsehen der Akten durch das Controlling einfach ermittelt werden. Darüber hinaus werden Übersichten zu hochpreisigen Verfahren und Materialien erstellt (Controllingbericht). Um die lückenlose Dokumentation jeder Behandlung zu gewährleisten, wird beim Abschluss eines Stationsaufenthalts eine Vollständigkeitsprüfung durchgeführt. Auch während der Behandlung weist COPRA auf eventuell noch zu dokumentierende Inhalte hin. Eine Vollständigkeitsprüfung kann bei jeder Freigabestufe der Dokumentation durchgeführt werden. So werden je nach Anlass verschiedene Inhalte beim Fachabteilungs- und Fallabschluss geprüft.\\n\\nCOPRA unterstützt damit die Dokumentation abrechnungsrelevanter Leistungen von der vollständigen Eingabe, Vollständigkeitsprüfung, Überleitung bis zum automatisierten Export.",
								"class": "prepend-1 prominent-headline prominent-headline--red"
							}
							]
						},
						{
							"class": "spacing-top spacing-bottom",
							"link": "IT-Abteilung",
							"content": [
								{
									"type": "block",
									"column": 8,
									"content": "##IT-Abteilung\\nDurch die Möglichkeit, Dienste für den Betrieb von COPRA auf verschiedenen Servern zu verteilen, ist COPRA beliebig skalierbar. COPRA kann mit der Inbetriebnahme weiterer Stationen oder Bereiche einfach auf die neuen Anforderungen angepasst werden.\\n\\nCOPRA ist komplett virtualisierbar. Die hausinterne IT erhält wichtige Freiheiten bei der Gestaltung der Infrastruktur. Auch das Ausfallkonzept kann frei gewählt werden. COPRA unterstützt dabei durch Empfehlungen und Angaben zu erwarteten Eigenschaften des Systems.\\n\\nDurch die lokale Datenspeicherung der COPRA-Clients sind die Stationen, die mit COPRA arbeiten durch einen temporären Ausfall der Verbindungen zu den COPRA-Diensten und der zentralen Datenbank nicht betroffen. Wartungsarbeiten werden dadurch erheblich erleichtert. Systemaktualisierungen sind dank einer integrierten Softwareverteilung in wenigen Schritten erledigt.\\n\\nCOPRA setzt auf etablierte Technologien wie Microsoft SQL Server und .NET Framework.",
									"class": "append-1 prominent-headline prominent-headline--red"
								},
								{
									"type": "block",
									"column": 4,
									"media": [
										{
											"src": "icon-it.svg",
											"description": "Vorteile für die IT"
										}
									],
									"content": "###Das wichtigste im Überblick\\n- Hohe Skalierbarkeit\n- Vollständig virtualisierbar\n- Jederzeit verfügbar\n- Bewährte Technologien, wie der SQL-Server und das .NET-Framework von Microsoft\n\n",
									"class": "circle-icon rounded-block rounded-block--red"
								}
								]
							}
				]',
				'created_at' => date("Y-m-d h:i:s"),
				'updated_at' => date("Y-m-d h:i:s"),
			),
			2 =>
			array (
				'id' => 3,
				'article_id' => 3,
				'menu_label' => 'Firmenprofil',
				'link' => 'firmenprofil',
				'published' => 1,
				'language' => 'de',
				'data' => '{
				"1":{
							"class": "section-01",
							"content": [
									{
											"type": "block",
											"column": 12,
											"media": [
													{
															"src": "company.jpg",
															"description": "Das PDMS, dem Medizin und Pflege vertrauen."
													}
											],
											"content": "##Das PDMS, dem Medizin und Pflege vertrauen.",
											"class": "banner js-banner"
									}
							]
					},
				"2":{
					"link": "Firmenwerte",
					"class": "spacing-bottom inner-section-padding-bottom inner-section-shadow teaser-box-section",
					"content": [
						{
							"type": "subsection",
							"column": 5,
							"class":"padded-column-small prepend-1",
							"content": [
								{
									"type": "block",
									"media":[
										{
											"src": "icon-listen.svg",
											"class": "media--noResize"
										}
									],
									"content": "##Starke Kundenorientierung\\nCOPRA ist dafür bekannt, in enger Abstimmung mit seinen Kunden sein Produkt beständig weiterzuentwickeln. Wir verstehen uns als Partner von Kliniken, Ärzten und Pflegepersonal. Anwender sind für uns Experten, die aus ihrer täglichen Arbeit heraus und durch ihre Erfahrungen mit der Praxis unser Programm täglich optimieren helfen.\\n\\nUnser Support ist in unser Unternehmen integriert. Als Unternehmen aus Deutschland verstehen wir die Vorgaben und Richtlinien der deutschen Medizinlandschaft ebenso gut wie die Sprache unserer Kunden. Gerade im Hinblick auf Support und Schulungen ein wichtiges Argument.\\n\\nDurch unsere jährlichen Anwendertreffen ist eine aktive COPRA-Community entstanden, die sich regelmäßig über die verschiedenen Lösungsansätze im stark individualisierbarem COPRA lebhaft austauscht.",
									"class": "padded-column padding-top-small teaser-card teaser-card--image-top teaser-card--quiet teaser-card--fadeBottom"
								}
							]
						},
						{
							"type": "subsection",
							"column": 5,
							"class":"padded-column-small",
							"content": [
								{
										"type": "block",
										"media":[
											{
												"src": "icon-innovation.svg",
												"class": "media--noResize"
												}
										],
										"content": "##Innovation\\nEin Großteil unserer Kunden sind Universitätskliniken, die am Puls der Zeit mit großem Forschungsinteresse neue Ideen entwickeln und ausprobieren wollen.\\n\\nFür bestimmte, besonders spezialisierte oder dynamische Bereiche arbeiten wir mit ausgewiesenen Experten zusammen. Eine Vielzahl von Treibern und hoch integrierten Anbindungen von Drittsystemen stellt sicher, dass COPRA die Sprache des jeweiligen Einsatzbereichs spricht.\\n\\nDa von der Funktionstüchtigkeit die Qualität von Behandlung und Pflege abhängen kann, versteht es sich für uns von selbst, dass COPRA auch im Offlinemodus verfügbar ist.",
										"class": "padded-column padding-top-small teaser-card teaser-card--image-top teaser-card--quiet teaser-card--fadeBottom"
								}
							]
						}
					]
				},
				"3":{
					"class": "section section--white-to-gray padding-bottom-wide",
					"link": "Firmengeschichte",
					"content": [
						{
							"type": "block",
							"column": 12,
							"content": "#Firmengeschichte"
						},
						{
							"type": "block",
							"column": 12,
							"content": ">> Die Firma COPRA System GmbH mit Sitz in Berlin gehört seit 1993 zu den führenden Anbietern von PDMS-Systemen in Deutschland.",
							"class":"spacing-bottom-small prepend-2 append-2"
						},
						{
							"type": "block",
							"column": 6,
							"content": "Mit über 20 hochspezialisierten Mitarbeitern steht die COPRA System GmbH für den schnellen, flexiblen Kontakt zwischen Klinik-Mitarbeitern und Software-Dienstleister. Unsere Entwicklungsabteilung ist direkt an unseren Support angegliedert und unterstützt unsere Kunden aus Kliniken und medizinischen Einrichtungen von unserem Standort in Berlin aus. Die beständige Weiterentwicklung der Software seit mittlerweile mehr als 20 Jahren spricht für sich. Mit der Version COPRA6 im Jahr 2007 haben wir einen echten Meilenstein in der Entwicklung elektronischer Patientendokumentationen erreicht.\\n\\n",
							"class": "spacing-bottom prepend-1 append-1"
						},
						{
							"type": "block",
							"column": 6,
							"content": "Durch die Verbundenheit mit unseren Anwendern gelingt es seit Jahren immer wieder aufs Neue, die komplexen Anforderungen an ein innovatives PDMS durch COPRA zu erfüllen.\\n\\nDabei geht es neben der Weiterentwicklung der Software auch um hohe Nutzerfreundlichkeit und die Priorisierung von Inhalten, um die tägliche Anwendung so unkompliziert wie möglich zu gestalten.\\n\\nCOPRA weiterzuentwickeln und gemeinsam mit unseren Kunden frühzeitig auf Veränderungen zu reagieren ist unser Bestreben, auch und vor allem im Sinn der Patienten und der Sicherstellung der herausragenden Qualität von medizinischer Behandlung und Pflege im deutschsprachigen Raum.",
							"class": "prepend-1 append-1 spacing-bottom"
						},
						{
							"type": "array",
							"column": 12,
							"class": "timeline",
							"content": [
								"####2013  \nVerlegung des Firmensitzes nach Berlin",
								"####2007  \nCOPRA6",
								"####2005  \nErste Inbetriebnahme in Österreich",
								"####2002  \nCOPRA5\\n\\nInbetriebnahme einer mehrsprachigen Version von COPRA in Luxemburg\\n\\nCOPRA wird auf einer Normalstation in Betrieb genommen",
								"####2001  \nGründung der Niederlassung in Berlin",
								"####1999  \nCOPRA wird auf einer Kinderintensivstation in Betrieb genommen",
								"####1998  \nCOPRA4",
								"####1997  \nErste Inbetriebnahme in der Schweiz",
								"####1996  \nCOPRA3\\n\\nErste Pumpenanbindung zur automatischen Medikamentendokumentation in COPRA",
								"####1994  \nCOPRA2\\n\\nErste Inbetriebnahme für den Routinebetrieb auf Intensivstation\\n\\nGründung in Sasbachwalden",
								"####1993  \nCOPRA1\n\nBeginn der Entwicklung in Leipzig"
							]
						}
					]
				}
				}',
				'created_at' => date("Y-m-d h:i:s"),
				'updated_at' => '2014-07-28 12:26:06',
			),
			3 =>
			array (
				'id' => 4,
				'article_id' => 4,
				'menu_label' => 'Referenzen',
				'link' => 'referenzen',
				'published' => 1,
				'language' => 'de',

				'data' => '{
					"1":{
						"class": "section-01",
						"content": [
							{
								"type": "block",
								"column": 12,
								"media": [
									{
										"src": "refrences.jpg",
										"description": "Some optional text"
									}
								],
								"content": "#Unsere Kunden",
								"class": "banner js-banner"
							}
						]
					},
					"2":{
						"class":"section-02",
						"content":[
							{
								"type": "stream",
								"column": 12,
								"stream": "references",
								"variables": {
									"itemCount": "true",
									"search": "true",
									"emptyState": "Mit ihren Kriterien konnte keine Referenz gefunden werden."
								},
								"mode": "card",
								"class": "grid js-searchable"
							}
						]
					}
				}',
				'created_at' => date("Y-m-d h:i:s"),
				'updated_at' => date("Y-m-d h:i:s"),

			),
			4 =>
			array (
				'id' => 5,
				'article_id' => 5,
				'menu_label' => 'Kontakt',
				'link' => 'kontakt',
				'published' => 1,
				'language' => 'de',
				'data' => '{
					"1":{
								"content": [
										{
												"type": "block",
												"column": 12,
												"media": [
														{
																"src": "contact.jpg",
																"description": "Kontakt"
														}
												],
												"content": "#Kontakt",
												"class": "banner js-banner"
										}
								]
						},
					"2":{
						"class": "spacing-bottom",
						"content":[{
							"type": "block",
							"column": 12,
							"content": "##Wir freuen uns auf Ihre Nachricht!",
							"class": "align-left"
							},{
								"type": "block",
								"column": 8,
								"content": "Sie haben Interesse an weiteren Informationen oder möchten einen Präsentationstermin mit uns vereinbaren, um die Bedienung und die Möglichkeiten unseres Patienten-Daten-Management-Systems COPRA kennenzulernen? Rufen Sie uns gerne unverbindlich an oder schreiben Sie uns. Unsere Mitarbeiter stehen Ihnen mit Rat und Tat zur Seite.",
								"class": "append-2"
							},{
									"type": "block",
									"column": 4,
									"content": "####COPRA System GmbH  \\n<span class=\"label\">Tel.:</span> +49 30 80 20 20 335  \\n<span class=\"label\">Fax:</span> +49 30 80 20 20 333  \\n<span class=\"label\">Email:</span> <mailto:vertrieb@copra-system.de>   \\n  \\n<span class=\"label\">Adresse:</span>  \\nBerliner Straße 112a  \\n13189 Berlin",
									"class": "contact-box"
							}
						]
					}
				}',
				'created_at' => date("Y-m-d h:i:s"),
				'updated_at' => date("Y-m-d h:i:s"),

			),
			5 =>
			array (
				'id' => 6,
				'article_id' => 6,
				'menu_label' => 'impressum',
				'link' => 'impressum',
				'published' => 1,
				'language' => 'de',
				'data' => '{
					"1": {
						"class": "section-01",
						"content": {
							"0": {
								"type": "block",
								"column": 12,
								"content": "#Impressum",
								"class": "page-title"
							},
							"1": {
								"type": "block",
								"column": 7,
								"content": "<h3>COPRA System GmbH</h3> <p>Berlin Berliner Straße 112a<br /> 13189 Berlin<br /> Tel.: +49 30 80 20 2033–0<br /> E-Mail: <a href=\"mailto: info@copra-system.de\">info@copra-system.de</a><br /> </p> <p>Gesch&#228;ftsführer: Martin Jekov</p>  <p>Amtsgericht Charlottenburg HRB 151375 B</p>  <h3>Verlinkte Seiten</h3> <p>Das Landgericht Hamburg hat mit seinem Urteil vom 12. Mai 1998 - 312 O 85/98 - “Haftung für Links” entschieden, dass die Betreiber einer Webseite durch die Anbringung eines Links die Inhalte der gelinkten Seite ggf. mit zu verantworten haben. Dies kann nur dadurch verhindert werden, dass sie sich ausdrücklich von diesen Inhalten distanzieren. Deshalb diese Erkl&#228;rung: Hiermit distanzieren sich die o.g. Betreiber der Webseite der COPRA System GmbH ausdrücklich von allen Inhalten aller gelinkten Seiten auf dieser Webseite und machen sich diese Inhalte nicht zu eigen. Diese Erkl&#228;rung gilt für alle auf dieser Webseite angebrachten Links. Für die Inhalte der mit dieser Homepage verlinkten Webseiten übernehmen die Betreiber keinerlei Verantwortung. Für den Inhalt sind ausschließlich die betreffenden Betreiber bzw. Autoren verantwortlich. Rechtswidrige Inhalte sind nicht bekannt. Falls Sie einen solchen Link finden, bitten wir um eine kurze Benachrichtigung, damit die Verlinkung entfernt werden kann. Wir übernehmen keine Haftung für die Erfüllung von Urheberrechtsbestimmungen auf einer von uns verlinkten Seite und auch keinerlei Verantwortung für weitere dort gesetzte Links. Alle in den Texten genannten oder abgebildeten Warenzeichen sind Warenzeichen der jeweiligen Inhaber und sind gesetzlich geschützt!</p>",
								"class": "space-bottom-wide full-width-copy append-1"
							}
						}
					}
				}',
				'created_at' => date("Y-m-d h:i:s"),
				'updated_at' => date("Y-m-d h:i:s"),

			),
			6 =>
			array (
				'id' => 7,
				'article_id' => 7,
				'menu_label' => 'Datenschutzrichtlinien',
				'link' => 'datenschutzrichtlinien',
				'published' => 1,
				'language' => 'de',
				'data' => '{
					"1": {
						"class": "section-01",
						"content": [
							{
								"type": "block",
								"column": 12,
								"content": "#Datenschutzrichtlinien",
								"class": "page-title"
							},
							{
								"type": "block",
								"column": 8,
								"content": "###Datenschutz\\nDie Nutzung unserer Webseite ist in der Regel ohne Angabe personenbezogener Daten möglich. Soweit auf unseren Seiten personenbezogene Daten (beispielsweise Name, Anschrift oder eMail-Adressen) erhoben werden, erfolgt dies, soweit möglich, stets auf freiwilliger Basis. Diese Daten werden ohne Ihre ausdrückliche Zustimmung nicht an Dritte weitergegeben.\\n\\nWir weisen darauf hin, dass die Datenübertragung im Internet (z.B. bei der Kommunikation per E-Mail) Sicherheitslücken aufweisen kann. Ein lückenloser Schutz der Daten vor dem Zugriff durch Dritte ist nicht möglich.\\n\\nDer Nutzung von im Rahmen der Impressumspflicht veröffentlichten Kontaktdaten durch Dritte zur Übersendung von nicht ausdrücklich angeforderter Werbung und Informationsmaterialien wird hiermit ausdrücklich widersprochen. Die Betreiber der Seiten behalten sich ausdrücklich rechtliche Schritte im Falle der unverlangten Zusendung von Werbeinformationen, etwa durch Spam-Mails, vor.\\n###Datenschutzerkl&#228;rung für die Nutzung von Google Analytics\\nDiese Website benutzt Google Analytics, einen Webanalysedienst der Google Inc. (“Google”). Google Analytics verwendet sog. “Cookies”, Textdateien, die auf Ihrem Computer gespeichert werden und die eine Analyse der Benutzung der Website durch Sie ermöglichen. Die durch den Cookie erzeugten Informationen über Ihre Benutzung dieser Website werden in der Regel an einen Server von Google in den USA übertragen und dort gespeichert. Im Falle der Aktivierung der IP-Anonymisierung auf dieser Webseite wird Ihre IP-Adresse von Google jedoch innerhalb von Mitgliedstaaten der Europ&#228;ischen Union oder in anderen Vertragsstaaten des Abkommens über den Europ&#228;ischen Wirtschaftsraum zuvor gekürzt.\\n\\nNur in Ausnahmef&#228;llen wird die volle IP-Adresse an einen Server von Google in den USA übertragen und dort gekürzt. Im Auftrag des Betreibers dieser Website wird Google diese Informationen benutzen, um Ihre Nutzung der Website auszuwerten, um Reports über die Websiteaktivit&#228;ten zusammenzustellen und um weitere mit der Websitenutzung und der Internetnutzung verbundene Dienstleistungen gegenüber dem Websitebetreiber zu erbringen. Die im Rahmen von Google Analytics von Ihrem Browser übermittelte IP-Adresse wird nicht mit anderen Daten von Google zusammengeführt.\\n\\nSie können die Speicherung der Cookies durch eine entsprechende Einstellung Ihrer Browser-Software verhindern; wir weisen Sie jedoch darauf hin, dass Sie in diesem Fall gegebenenfalls nicht s&#228;mtliche Funktionen dieser Website vollumf&#228;nglich werden nutzen können. Sie können darüber hinaus die Erfassung der durch das Cookie erzeugten und auf Ihre Nutzung der Website bezogenen Daten (inkl. Ihrer IP-Adresse) an Google sowie die Verarbeitung dieser Daten durch Google verhindern, indem sie das unter dem folgenden Link verfügbare Browser-Plugin herunterladen und installieren: [http://tools.google.com/dlpage/gaoptout?hl=de](http://tools.google.com/dlpage/gaoptout?hl=de).",
								"class": "append-2 space-bottom-wide"
							},{
								"type": "block",
								"column": 4,
								"content": "####COPRA System GmbH  \\n<span class=\"label\">Tel.:</span> +49 30 80 20 20 335  \\n<span class=\"label\">Fax:</span> +49 30 80 20 20 333  \\n<span class=\"label\">Email:</span> <mailto:vertrieb@copra-system.de>   \\n  \\n<span class=\"label\">Adresse:</span>  \\nBerliner Straße 112a  \\n13189 Berlin",
								"class": "contact-box"
							}
						]
					}
				}',
				'created_at' => date("Y-m-d h:i:s"),
				'updated_at' => date("Y-m-d h:i:s"),

			),
			7 =>
			array (
			'id' => 8,
			'article_id' => 8,
			'menu_label' => '',
			'link' => '',
			'published' => 1,
			'language' => 'de',
			'data' => '[
				{
					"content":[
						{
							"type": "block",
							"column": 2,
							"media": [
								{
									"src": "hirslanden-klinik.jpg",
									"description": "Erste Hirslanden Klinik startet mit COPRA"
								}
							],
							"content": "#Erste Hirslanden Klinik startet mit COPRA\\nDie Hirslanden Klinik Aarau startete im 3. Quartal 2014 mit COPRA auf der Intensivstation (IPS) und auf der An&#228;sthesie (OP) als Pilot für die gesamte Gruppe."
						}
						]
					}
					]',
					'created_at' => date("Y-m-d h:i:s"),
					'updated_at' => date("Y-m-d h:i:s"),
			),
			8 =>
			array (
				'id' => 9,
				'article_id' => 9,
				'menu_label' => '',
				'link' => '',
				'published' => 1,
				'language' => 'de',
				'data' => '[
					{
						"content":[
							{
								"type": "block",
								"column": 2,
								"content": "#Clinical Documentation Challenge (CDC)\\nCOPRA nimmt an der diesj&#228;hrigen CDC auf der DIVI14 am 04.12.2014 in Hamburg teil. Das Thema ist Medizincontrolling. Es nehmen 5 weitere PDMS-Hersteller an dem Wettbewerb teil."
							}
							]
						}
						]',
				'created_at' => date("Y-m-d h:i:s"),
				'updated_at' => date("Y-m-d h:i:s"),
			),
			9 =>
			array (
				'id' => 10,
				'article_id' => 10,
				'menu_label' => '',
				'link' => '',
				'published' => 1,
				'language' => 'de',
				'data' => '[
					{
						"content":[
							{
								"type": "block",
								"column": 2,
								"content": "#Neues Corporate Design\\nCOPRA bekommt ein neues Corporate Design und tritt zur DIVI14 erstmalig im neuen Aussehen auf."
							}
						]
					}
				]',
				'created_at' => date("Y-m-d h:i:s"),
				'updated_at' => date("Y-m-d h:i:s"),
			)
		));
	}

}
