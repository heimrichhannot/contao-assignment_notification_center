<?php

$dc = &$GLOBALS['TL_DCA']['tl_nc_message'];

/**
 * Palettes
 */
$dc['palettes']['__selector__'][] = 'addAssignment';
$dc['palettes']['email']          = str_replace('{publish_legend}', '{assignment_legend},addAssignment;{publish_legend}', $dc['palettes']['email']);


/**
 * Subpalettes
 */
$dc['subpalettes']['addAssignment'] = 'assignmentArchive,assignmentMapping,assignmentFallbackEmails,assignmentFallbackForce';

/**
 * Fields
 */
$arrFields = [
    'addAssignment'            => [
        'label'     => &$GLOBALS['TL_LANG']['tl_nc_message']['addAssignment'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50', 'submitOnChange' => true],
        'sql'       => "char(1) NOT NULL default ''",
    ],
    'assignmentArchive'        => [
        'label'            => &$GLOBALS['TL_LANG']['tl_nc_message']['assignmentArchive'],
        'exclude'          => true,
        'inputType'        => 'select',
        'options_callback' => ['HeimrichHannot\Assignment\Backend\NcMessage', 'getAssignmentArchives'],
        'foreignKey'       => 'tl_assignment.title',
        'sql'              => "int(10) unsigned NOT NULL default '0'",
        'relation'         => ['type' => 'belongsTo', 'load' => 'lazy'],
        'eval'             => ['mandatory' => true, 'tl_class' => 'clr', 'includeBlankOption' => true, 'submitOnChange' => true],
    ],
    'assignmentMapping'        => [
        'label'     => &$GLOBALS['TL_LANG']['tl_nc_message']['assignmentMapping'],
        'inputType' => 'multiColumnEditor',
        'eval'      => [
            'mandatory'         => true,
            'multiColumnEditor' => [
                // set to 0 if it should also be possible to have *no* row (default: 1)
                'minRowCount' => 1,
                'fields'      => [
                    'value' => [
                        'label'     => &$GLOBALS['TL_LANG']['tl_nc_message']['assignmentMapping_value'],
                        'inputType' => 'text',
                    ],
                    'field' => [
                        'label'     => &$GLOBALS['TL_LANG']['tl_nc_message']['assignmentMapping_field'],
                        'inputType' => 'text',
                    ],
                ],
            ],
        ],
        'sql'       => "blob NULL",
    ],
    'assignmentFallbackEmails' => [
        'label'         => &$GLOBALS['TL_LANG']['tl_nc_message']['assignmentFallbackEmails'],
        'exclude'       => true,
        'inputType'     => 'text',
        'eval'          => ['tl_class' => 'long clr', 'decodeEntities' => true, 'mandatory' => true],
        'sql'           => "varchar(255) NOT NULL default ''",
        'save_callback' => [
            ['NotificationCenter\tl_nc_language', 'validateEmailList'],
        ],
    ],
    'assignmentFallbackForce'  => [
        'label'     => &$GLOBALS['TL_LANG']['tl_nc_message']['assignmentFallbackForce'],
        'exclude'   => true,
        'inputType' => 'checkbox',
        'eval'      => ['tl_class' => 'w50'],
        'sql'       => "char(1) NOT NULL default ''",
    ],
];

$dc['fields'] = array_merge($dc['fields'], $arrFields);