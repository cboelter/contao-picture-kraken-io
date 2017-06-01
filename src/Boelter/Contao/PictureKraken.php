<?php

namespace Boelter\Contao;

/**
 * Class PictureKraken
 *
 * @package Boelter\Contao
 */
class PictureKraken extends \Picture
{
    /**
     * Get the attributes for one picture source element
     *
     * @param object|\Model $imageSize The image size or image size item model
     *
     * @return array The source element attributes
     */
    protected function getTemplateDataSource($imageSize)
    {
        $densities = array();

        if (!empty($imageSize->densities) && ($imageSize->width || $imageSize->height)) {
            $densities = array_filter(array_map('floatval', explode(',', $imageSize->densities)));
        }

        array_unshift($densities, 1);
        $densities = array_values(array_unique($densities));

        $file1x     = null;
        $attributes = array();
        $srcset     = array();

        foreach ($densities as $density) {
            $imageObj    = clone $this->image;
            $compression = false;
            $imageObj->setTargetWidth((int)$imageSize->width * $density)
                ->setTargetHeight((int)$imageSize->height * $density)
                ->setResizeMode($imageSize->resizeMode)
                ->setZoomLevel($imageSize->zoom);

            if (!file_exists(TL_ROOT . '/' . $imageObj->getCacheName())) {
                $compression = true;
            }

            $src = $imageObj->executeResize()->getResizedPath();

            if ($compression && strpos($src, 'assets') !== false) {

                $this->handleCompression($src);

            } elseif (strpos($src, 'assets') === false) {
                if (!file_exists(TL_ROOT . '/' . $imageObj->getCacheName())) {

                    $src = $this->handleCompression($src, $imageObj->getCacheName());

                } else {
                    $src = $imageObj->getCacheName();
                }
            }

            $fileObj = new \File(rawurldecode($src), true);

            if (empty($attributes['src'])) {
                $attributes['src']    = htmlspecialchars(TL_FILES_URL . $src, ENT_QUOTES);
                $attributes['width']  = $fileObj->width;
                $attributes['height'] = $fileObj->height;
                $file1x               = $fileObj;
            }

            $descriptor = '1x';

            if (count($densities) > 1) {
                // Use pixel density descriptors if the sizes attribute is empty
                if (empty($imageSize->sizes)) {
                    if ($fileObj->width && $file1x->width) {
                        $descriptor = rtrim(sprintf('%.3F', $fileObj->width / $file1x->width), '.0') . 'x';
                    }
                } // Otherwise use width descriptors
                else {
                    $descriptor = $fileObj->width . 'w';
                }

                $src .= ' ' . $descriptor;
            }

            if (!isset($srcset[$descriptor])) {
                $srcset[$descriptor] = TL_FILES_URL . $src;
            }
        }

        $attributes['srcset'] = htmlspecialchars(implode(', ', $srcset), ENT_QUOTES);

        if (!empty($imageSize->sizes)) {
            $attributes['sizes'] = htmlspecialchars($imageSize->sizes, ENT_QUOTES);
        }

        if (!empty($imageSize->media)) {
            $attributes['media'] = htmlspecialchars($imageSize->media, ENT_QUOTES);
        }

        return $attributes;
    }

    /**
     * Handle the compression exchange with kraken.io platform
     *
     * @param string $src
     * @param string $customTargetPath
     *
     * @return string
     */
    protected function handleCompression($src, $customTargetPath = '')
    {
        if (!$GLOBALS['TL_CONFIG']['kraken_api_key'] || !$GLOBALS['TL_CONFIG']['kraken_api_secret']) {
            return $src;
        }

        $data   = null;
        $kraken = new \Kraken($GLOBALS['TL_CONFIG']['kraken_api_key'], $GLOBALS['TL_CONFIG']['kraken_api_secret']);
        $params = array(
            "wait" => true,
        );

        if ($GLOBALS['TL_CONFIG']['kraken_compression_type'] == 'lossy') {
            $params['lossy'] = true;

            if ($GLOBALS['TL_CONFIG']['kraken_compression_quality']) {
                $params['quality'] = $GLOBALS['TL_CONFIG']['kraken_compression_quality'];
            }
        }

        if (!$GLOBALS['TL_CONFIG']['kraken_image_sender'] || $GLOBALS['TL_CONFIG']['kraken_image_sender'] == 'upload') {
            $params['file'] = TL_ROOT . '/' . $src;
            $data           = $kraken->upload($params);
        }

        if ($GLOBALS['TL_CONFIG']['kraken_image_sender'] == 'url') {
            $params['url'] = \Environment::get('url') . '/' . $src;
            $data          = $kraken->url($params);
        }

        if (!is_array($data) || !$data['success'] == 1) {
            return $src;
        }

        $fileBuffer = file_get_contents($data['kraked_url']);
        $file       = new \File($customTargetPath ?: $src);
        $file->write($fileBuffer);
        $file->close();

        return $file->path;
    }
}