<?php

namespace utils;

class Image {

	/**
	 * Vrátí odkaz na obrázek, který je ve složce images v rootu šablony
	 *
	 * @param string $fileName
	 *
	 * @return string
	 *
	 */
	public static function imageGetUrlFromTheme( $fileName ) {
		return $url = get_template_directory_uri() . "/images/" . $fileName;
	}

	public static function getImageAlt( $ImageId ): ?string {
		$ImageAlt = get_post_meta( $ImageId, '_wp_attachment_image_alt', true );
		if ( ! Util::issetAndNotEmpty( $ImageAlt ) ) {
			$ImageAlt = get_the_title( $ImageId );
		}

		return $ImageAlt;
	}

	/**
	 * Vrátí src obrázku podle ID a velikosti
	 *
	 * @param string $id
	 * @param string $sizeConstant
	 *
	 * @return string
	 */
	public static function getImageSrc( $id, $sizeConstant ) {
		$src = wp_get_attachment_image_src( $id, $sizeConstant );
		if ( Util::arrayIssetAndNotEmpty( $src ) ) {
			return reset( $src );
		}
	}

	public static function getImageWidth( $id, $sizeConstant ) {
		$src = wp_get_attachment_image_src( $id, $sizeConstant );
		if ( Util::arrayIssetAndNotEmpty( $src ) ) {
			return $src[1];
		}
	}

	public static function getCloudImage( $id, $width, $height = null, $crop = 'fill', $quality = 'auto:eco', $effect = null ) {
		$src = wp_get_attachment_image_src( $id, 'full' );

		if ( ! $src ) {
			return '';
		}

		$OriginalWidth  = $src[1];
		$OriginalHeight = $src[2];

		if ( 2 * $OriginalWidth < $width ) {
			return "";
		}
		if ( 2 * $OriginalHeight < $height ) {
			return "";
		}

		if ( function_exists( 'cloudinary_url' ) ) {

			// if "Auto Cloudinary" plugin exists -> get the image url with the specified and predefined parameters from Cloudinary service

			$args = [
				'transform' => [
					'width'        => $width,
					'height'       => $height,
					'crop'         => $crop,
					'quality'      => $quality,
					'fetch_format' => 'auto',
				],
			];

			if ( $effect ) {
				$args['transform'] += [ 'effect' => $effect ];
			}

			$image_url = cloudinary_url( $id, $args );
		} elseif ( function_exists( 'fly_add_image_size' ) ) {
			// if "Auto Cloudinary" plugin doesn't exist but "Fly Dynamic Image Resizer" exists -> get the image with the specified width and height from local server

			$img = fly_get_attachment_image_src( $id, array( $width, $height ), true );
			if ( isset( $img['src'] ) ) {
                var_dump(wp_get_original_image_path( $id ));
				if ( self::isSvg( wp_get_original_image_path( $id ) ) ) {
					$image_url = wp_get_attachment_image_src( $id )[0];
				} else if (self::isWebp( wp_get_original_image_path( $id ) )) {
                    var_dump('here');
                    $image_url = wp_get_attachment_image_src( $id )[0];
                } else {
					$image_url = $img['src'];
				}
			} else {
				$image_url = wp_get_attachment_image_src( $id )[0];
			}
		} else {

			// if neither plugin works -> get only the url of the image from local server

			$image_url = wp_get_attachment_image_src( $id )[0];
		}

		return esc_url( $image_url );
	}


	public static function isSvg( $filePath ) {
		if ( $filePath ) {
			return 'image/svg+xml' === mime_content_type( $filePath );
		}

		return false;
	}

    public static function isWebp( $filePath ) {
        if ( $filePath ) {
            return 'image/webp' === mime_content_type( $filePath );
        }

        return false;
    }
}
