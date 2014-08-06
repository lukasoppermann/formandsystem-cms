<?php namespace Lukasoppermann\Optimization;
/**
 * Simple CSS Minification
 *
 * @since 1.0.0
 * @author Lukas Oppermann
 *
 * @param string $css CSS to minify
 * @return string Minified CSS
 */
class CssMin{

	public static function minify( $css ) 
	{
		// Normalize whitespace
		$css = preg_replace( '/\s+/', ' ', $css );

		// Remove comment blocks, everything between /* and */, unless
		// preserved with /*! ... */
		$css = preg_replace( '/\/\*[^\!](.*?)\*\//', '', $css );

		// Remove space after , : ; { }
		$css = preg_replace( '/(,|:|;|\{|}) /', '$1', $css );

		// Remove space before , ; { }
		$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

		// Strips leading 0 on decimal values (converts 0.5px into .5px)
		$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

		// Strips units if value is 0 (converts 0px to 0)
		$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

		// Converts all zeros value into short-hand
		$css = preg_replace( '/0 0 0 0/', '0', $css );

		// Shortern 6-character hex color codes to 3-character where possible
		$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );
		
		// replace font.* bold = 700 and normal = 400
		$css = preg_replace( '/(font.*)(normal)/', '${1}400', $css );
		$css = preg_replace( '/(font.*)(bold)/', '${1}700', $css );
		
		return trim( $css );
	}
}