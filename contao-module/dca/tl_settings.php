<?php

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] =
    $GLOBALS['TL_DCA']['tl_settings']['palettes']['default']
    . ';{picture_kraken},kraken_api_key,kraken_api_secret,kraken_image_sender,kraken_compression_type,kraken_compression_quality';

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['kraken_api_key'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['kraken_api_key'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => array('maxlength' => 255, 'tl_class' => 'w50'),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['kraken_api_secret'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['kraken_api_secret'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => array('maxlength' => 255, 'tl_class' => 'w50'),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['kraken_image_sender'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['kraken_image_sender'],
    'exclude'   => true,
    'inputType' => 'select',
    'options'   => array('upload', 'url'),
    'reference' => &$GLOBALS['TL_LANG']['tl_settings']['kraken_image_sender']['options'],
    'eval'      => array('tl_class' => 'w50'),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['kraken_compression_type'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['kraken_compression_type'],
    'exclude'   => true,
    'inputType' => 'select',
    'options'   => array('lossy'),
    'eval'      => array('tl_class' => 'clr w50', 'includeBlankOption' => true, 'blankOptionLabel' => 'losless'),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['kraken_compression_quality'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_settings']['kraken_compression_quality'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => array('tl_class' => 'w50', 'rgxp' => 'numeric'),
);
