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
$arrLang['addAssignment']     = ['Add assignment', 'Add assignment configuration and use ##assignee_## tokens.'];
$arrLang['assignmentArchive'] = ['Assignment archive', 'Select the assignment archive to check against assignment data conditions.'];
$arrLang['assignmentMapping'] = ['Assignment mapping', 'Declare assignment mapping conditions.'];
$arrLang['assignmentMapping_value'] = ['Value/token', 'Enter the name of the token like `form_value_postal` or a value like `de`.'];
$arrLang['assignmentMapping_field'] = ['Field name', 'Enter the name of the `tl_assignment_data` field like `postal`.'];
$arrLang['assignmentFallbackEmails'] = ['Default emails (Fallback)', 'Specify multiple e-mails to be used if no assignment could be made.'];
$arrLang['assignmentFallbackForce'] = ['Always add default emails', 'Even if assignments have been found, the default emails are added.'];

/**
 * Legends
 */
$arrLang['assignment_legend'] = 'Assignments';