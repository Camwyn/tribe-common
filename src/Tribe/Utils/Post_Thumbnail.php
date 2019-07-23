<?php
/**
 * Wraps the logic to lazy load a post thumbnail information.
 *
 * Example usage:
 * ```php
 * $post_thumbnail = new Tribe\Utils\Post_Thumbnail( $post_id );
 *
 * // ...some code later...
 *
 * // The post thumbnail data is fetched only now.
 * $large_url = $post_thumbnail->large->url;
 * ```
 *
 * @since   TBD
 * @package Tribe\Utils
 */


namespace Tribe\Utils;

use Tribe__Utils__Array as Arr;

/**
 * Class Post_Thumbnail
 *
 * @since   TBD
 * @package Tribe\Utils
 */
class Post_Thumbnail implements \ArrayAccess {
	/**
	 * An array of the site image sizes, including the `full` one.
	 *
	 * @since TBD
	 *
	 * @var array
	 */
	protected $image_sizes;

	/**
	 * The post ID this images collection is for.
	 *
	 * @since TBD
	 *
	 * @var int
	 */
	protected $post_id;

	/**
	 * The post thumbnail data.
	 *
	 * @since TBD
	 *
	 * @var array
	 */
	protected $post_thumbnail_data;

	/**
	 * Post_Images constructor.
	 *
	 * @param int $post_id The post ID.
	 */
	public function __construct( $post_id ) {
		$this->post_id = $post_id;
	}

	/**
	 * {@inheritDoc}
	 */
	public function __get( $property ) {
		return $this->offsetGet( $property );
	}

	/**
	 * {@inheritDoc}
	 */
	public function __set( $property, $value ) {
		$this->offsetSet( $property, $value );
	}

	/**
	 * {@inheritDoc}
	 */
	public function __isset( $property ) {
		return $this->offsetExists( $property );
	}

	/**
	 * Fetches and returns the image sizes registered on the site, if any.
	 *
	 * @since TBD
	 *
	 * @return array An array of the registered image sizes.
	 */
	public function get_image_sizes() {
		if ( null !== $this->image_sizes ) {
			return $this->image_sizes;
		}

		$image_sizes = array_merge( [ 'full' ], get_intermediate_image_sizes() );

		/**
		 * Filters the image sizes the `Tribe\Utils\Post_Thumbnail` class will manage and fetch data for.
		 *
		 * @since TBD
		 *
		 * @param array $image_sizes All the available image sizes; this includes the default and the intermediate ones.
		 */
		$this->image_sizes = apply_filters( 'tribe_post_thumbnail_image_sizes', $image_sizes );

		return $this->image_sizes;
	}

	/**
	 * Returns the data about the post thumbnail, if any.
	 *
	 * @since TBD
	 *
	 * @return array An array of objects containing the post thumbnail data.
	 */
	public function get_post_thumbnail_data() {
		if ( null !== $this->post_thumbnail_data ) {
			return $this->post_thumbnail_data;
		}

		$post_id     = $this->post_id;
		$image_sizes = $this->get_image_sizes();

		$thumbnail_id = get_post_thumbnail_id( $post_id );

		if ( empty( $thumbnail_id ) ) {
			return [];
		}

		$thumbnail_data = array_combine(
			$image_sizes,
			array_map( static function ( $size ) use ( $thumbnail_id ) {
				$size_data = wp_get_attachment_image_src( $thumbnail_id, $size );

				if(false === $size_data){
					return (object)[
						'url' => '',
						'width' => '',
						'height' => '',
						'is_intermediate' => false,
					];
				}

				return (object) [
					'url'             => Arr::get( $size_data, 0, '' ),
					'width'           => Arr::get( $size_data, 1, '' ),
					'heigth'          => Arr::get( $size_data, 2, '' ),
					'is_intermediate' => (bool)Arr::get( $size_data, 3, false ),
				];
			}, $image_sizes )
		);

		$srcset                   = wp_get_attachment_image_srcset( $thumbnail_id );
		$thumbnail_data['srcset'] = ! empty( $srcset ) ? $srcset : false;

		/**
		 * Filters the post thumbnail data and information that will be returned for a specific post.
		 *
		 * Note that the thumbnail data will be cast to an object after this filtering.
		 *
		 * @since TBD
		 *
		 * @param array $thumbnail_data The thumbnail data for the post.
		 * @param int   $post_id        The ID of the post the data is for.
		 */
		$thumbnail_data = apply_filters( 'tribe_post_thumbnail_data', $thumbnail_data, $post_id );

		return $thumbnail_data;
	}

	/**
	 * {@inheritDoc}
	 */
	public function offsetExists( $offset ) {
		$this->post_thumbnail_data = $this->get_post_thumbnail_data();

		return isset( $this->post_thumbnail_data[ $offset ] );
	}

	/**
	 * {@inheritDoc}
	 */
	public function offsetGet( $offset ) {
		$this->post_thumbnail_data = $this->get_post_thumbnail_data();

		return isset( $this->post_thumbnail_data[ $offset ] )
			? $this->post_thumbnail_data[ $offset ]
			: null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function offsetSet( $offset, $value ) {
		$this->post_thumbnail_data = $this->get_post_thumbnail_data();

		$this->post_thumbnail_data[ $offset ] = $value;
	}

	/**
	 * {@inheritDoc}
	 */
	public function offsetUnset( $offset ) {
		$this->post_thumbnail_data = $this->get_post_thumbnail_data();

		unset( $this->post_thumbnail_data[ $offset ] );
	}

	public function to_array() {
		$this->post_thumbnail_data = $this->get_post_thumbnail_data();

		return json_decode( json_encode( $this->post_thumbnail_data ), true );
	}
}
