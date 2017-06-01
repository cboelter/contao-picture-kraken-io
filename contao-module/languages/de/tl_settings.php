<?php

/**
 * Palettes
 */
$GLOBALS['TL_LANG']['tl_settings']['picture_kraken'] = 'Kraken.io Bild-Kompression';

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_settings']['kraken_api_key']             =
    array('API-Key', 'Bitte geben Sie Ihren API-Key ein.');
$GLOBALS['TL_LANG']['tl_settings']['kraken_api_secret']          =
    array('API-Secret', 'Bitte geben Sie Ihren API-Secret ein.');
$GLOBALS['TL_LANG']['tl_settings']['kraken_image_sender']        =
    array('Übertragungsart', 'Bitte wählen Sie die Übertragungsart.');
$GLOBALS['TL_LANG']['tl_settings']['kraken_compression_type']    =
    array('Komprimierungs-Typ', 'Bitte wählen Sie den Typ der Komprimierung.');
$GLOBALS['TL_LANG']['tl_settings']['kraken_compression_quality'] =
    array(
        'Komprimierungs-Qualität',
        'Bitte wählen Sie die Qualität der Komprimierung. Funktioniert nur mit Komprimierungs-Typ: lossy',
    );

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_settings']['kraken_image_sender']['options']['upload'] = 'Upload';
$GLOBALS['TL_LANG']['tl_settings']['kraken_image_sender']['options']['url']    =
    'Download durch kraken.io (funktioniert nur auf öffentlichen Servern)';