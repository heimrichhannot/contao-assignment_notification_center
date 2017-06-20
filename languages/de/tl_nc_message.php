<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Heimrich & Hannot GmbH
 *
 * @author  Rico Kaltofen <r.kaltofen@heimrich-hannot.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$arrLang = &$GLOBALS['TL_LANG']['tl_nc_message'];

/**
 * Fields
 */
$arrLang['addAssignment']     = ['Zuordnung hinzufügen', 'Fügen eine Zuordnungskonfiguration hinzu und verwende ##assignee_## tokens im Template.'];
$arrLang['assignmentArchive'] = ['Zuordnungsarchiv', 'Wählen Sie das Zuordnungsarchiv aus zur Überprüfung der Zuordnungsdatenbedingungen aus.'];
$arrLang['assignmentMapping'] = ['Zuordnungskonfiguration', 'Deklariere die Zuordnungskonfiguration.'];
$arrLang['assignmentMapping_value'] = ['Wert/Token', 'Geben Sie den Namen des Tokens wie `form_value_postal` oder einen Wert wie `de` ein.'];
$arrLang['assignmentMapping_field'] = ['Feldname', 'Geben Sie den Namen des `tl_assignment_data` Feldes wie `postal` ein.'];
$arrLang['assignmentFallbackEmails'] = ['Standard E-Mails (Fallback)', 'Geben Sie mehrer E-Mails an an die verwendet werden sollen, wenn keine Zuordnung getroffen werden konnte.'];
$arrLang['assignmentFallbackForce'] = ['Standard E-Mails immer hinzufügen', 'Auch wenn Zuordnungen gefunden wurden, werden die Standard E-Mails hinzugefügt.'];

/**
 * Legends
 */
$arrLang['assignment_legend'] = 'Zuordnungen';