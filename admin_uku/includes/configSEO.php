<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
//FUNCIONES PARA SEO
/**
 * Translates a decimal analysis score into a textual one.
 *
 * @static
 *
 * @param int  $val       The decimal score to translate.
 * @param bool $css_value Whether to return the i18n translated score or the CSS class value.
 *
 * @return string
 */
function translate_score( $val, $css_value = true ) {
	if ( $val > 10 ) {
		$val = round( $val / 10 );
	}
	switch ( $val ) {
		case 0:
			$score = '';
			$css   = 'na';
			break;
		case 4:
		case 5:
			$score = '';
			$css   = 'poor';
			break;
		case 6:
		case 7:
			$score = '';
			$css   = 'ok';
			break;
		case 8:
		case 9:
		case 10:
			$score = '';
			$css   = 'good';
			break;
		default:
			$score = '';
			$css   = 'bad';
			break;
	}

	if ( $css_value ) {
		return $css;
	}
	else {
		return $score;
	}
}

/**
 * Standardize whitespace in a string
 *
 * Replace line breaks, carriage returns, tabs with a space, then remove double spaces.
 *
 * @static
 *
 * @param string $string
 *
 * @return string
 */
function standardize_whitespace( $string ) {
	return trim( str_replace( '  ', ' ', str_replace( array( "\t", "\n", "\r", "\f" ), ' ', $string ) ) );
}

/**
 * Lowercase a sentence while preserving "weird" characters.
 *
 * This should work with Greek, Russian, Polish & French amongst other languages...
 *
 * @param string $string String to lowercase.
 *
 * @return string
 */
function strtolower_utf8( $string ) {

	// Prevent comparison between utf8 characters and html entities (é vs &eacute;).
	$string = html_entity_decode( $string );

	$convert_to   = array(
		'a',
		'b',
		'c',
		'd',
		'e',
		'f',
		'g',
		'h',
		'i',
		'j',
		'k',
		'l',
		'm',
		'n',
		'o',
		'p',
		'q',
		'r',
		's',
		't',
		'u',
		'v',
		'w',
		'x',
		'y',
		'z',
		'à',
		'á',
		'â',
		'ã',
		'ä',
		'å',
		'æ',
		'ç',
		'è',
		'é',
		'ê',
		'ë',
		'ì',
		'í',
		'î',
		'ï',
		'ð',
		'ñ',
		'ò',
		'ó',
		'ô',
		'õ',
		'ö',
		'ø',
		'ù',
		'ú',
		'û',
		'ü',
		'ý',
		'а',
		'б',
		'в',
		'г',
		'д',
		'е',
		'ё',
		'ж',
		'з',
		'и',
		'й',
		'к',
		'л',
		'м',
		'н',
		'о',
		'п',
		'р',
		'с',
		'т',
		'у',
		'ф',
		'х',
		'ц',
		'ч',
		'ш',
		'щ',
		'ъ',
		'ы',
		'ь',
		'э',
		'ю',
		'я',
		'ą',
		'ć',
		'ę',
		'ł',
		'ń',
		'ó',
		'ś',
		'ź',
		'ż',
	);
	$convert_from = array(
		'A',
		'B',
		'C',
		'D',
		'E',
		'F',
		'G',
		'H',
		'I',
		'J',
		'K',
		'L',
		'M',
		'N',
		'O',
		'P',
		'Q',
		'R',
		'S',
		'T',
		'U',
		'V',
		'W',
		'X',
		'Y',
		'Z',
		'À',
		'Á',
		'Â',
		'Ã',
		'Ä',
		'Å',
		'Æ',
		'Ç',
		'È',
		'É',
		'Ê',
		'Ë',
		'Ì',
		'Í',
		'Î',
		'Ï',
		'Ð',
		'Ñ',
		'Ò',
		'Ó',
		'Ô',
		'Õ',
		'Ö',
		'Ø',
		'Ù',
		'Ú',
		'Û',
		'Ü',
		'Ý',
		'А',
		'Б',
		'В',
		'Г',
		'Д',
		'Е',
		'Ё',
		'Ж',
		'З',
		'И',
		'Й',
		'К',
		'Л',
		'М',
		'Н',
		'О',
		'П',
		'Р',
		'С',
		'Т',
		'У',
		'Ф',
		'Х',
		'Ц',
		'Ч',
		'Ш',
		'Щ',
		'Ъ',
		'Ъ',
		'Ь',
		'Э',
		'Ю',
		'Я',
		'Ą',
		'Ć',
		'Ę',
		'Ł',
		'Ń',
		'Ó',
		'Ś',
		'Ź',
		'Ż',
	);

	return str_replace( $convert_from, $convert_to, $string );
}

/**
* Returns the stopwords for the current language
*
* @since 1.1.7
*
* @return array $stopwords array of stop words to check and / or remove from slug
*/
function stopwords() {
	/* translators: this should be an array of stopwords for your language, separated by comma's. */
	$stopwords = explode( ',', "él,ésta,éstas,éste,éstos,última,últimas,último,últimos,a,añadió,aún,actualmente,adelante,además,afirmó,agregó,ahí,ahora,al,algún,algo,alguna,algunas,alguno,algunos,alrededor,ambos,ante,anterior,antes,apenas,aproximadamente,aquí,así,aseguró,aunque,ayer,bajo,bien,buen,buena,buenas,bueno,buenos,cómo,cada,casi,cerca,cierto,cinco,comentó,como,con,conocer,consideró,considera,contra,cosas,creo,cual,cuales,cualquier,cuando,cuanto,cuatro,cuenta,da,dado,dan,dar,de,debe,deben,debido,decir,dejó,del,demás,dentro,desde,después,dice,dicen,dicho,dieron,diferente,diferentes,dijeron,dijo,dio,donde,dos,durante,e,ejemplo,el,ella,ellas,ello,ellos,embargo,en,encuentra,entonces,entre,era,eran,es,esa,esas,ese,eso,esos,está,están,esta,estaba,estaban,estamos,estar,estará,estas,este,esto,estos,estoy,estuvo,ex,existe,existen,explicó,expresó,fin,fue,fuera,fueron,gran,grandes,ha,había,habían,haber,habrá,hace,hacen,hacer,hacerlo,hacia,haciendo,han,hasta,hay,haya,he,hecho,hemos,hicieron,hizo,hoy,hubo,igual,incluso,indicó,informó,junto,la,lado,las,le,les,llegó,lleva,llevar,lo,los,luego,lugar,más,manera,manifestó,mayor,me,mediante,mejor,mencionó,menos,mi,mientras,misma,mismas,mismo,mismos,momento,mucha,muchas,mucho,muchos,muy,nada,nadie,ni,ningún,ninguna,ningunas,ninguno,ningunos,no,nos,nosotras,nosotros,nuestra,nuestras,nuestro,nuestros,nueva,nuevas,nuevo,nuevos,nunca,o,ocho,otra,otras,otro,otros,para,parece,parte,partir,pasada,pasado,pero,pesar,poca,pocas,poco,pocos,podemos,podrá,podrán,podría,podrían,poner,por,porque,posible,próximo,próximos,primer,primera,primero,primeros,principalmente,propia,propias,propio,propios,pudo,pueda,puede,pueden,pues,qué,que,quedó,queremos,quién,quien,quienes,quiere,realizó,realizado,realizar,respecto,sí,sólo,se,señaló,sea,sean,según,segunda,segundo,seis,ser,será,serán,sería,si,sido,siempre,siendo,siete,sigue,siguiente,sin,sino,sobre,sola,solamente,solas,solo,solos,son,su,sus,tal,también,tampoco,tan,tanto,tenía,tendrá,tendrán,tenemos,tener,tenga,tengo,tenido,tercera,tiene,tienen,toda,todas,todavía,todo,todos,total,tras,trata,través,tres,tuvo,un,una,unas,uno,unos,usted,va,vamos,van,varias,varios,veces,ver,vez,y,ya,yo" );
	/**
	 * Allows filtering of the stop words list
	 * Especially useful for users on a language in which WPSEO is not available yet
	 * and/or users who want to turn off stop word filtering
	 * @api  array  $stopwords  Array of all lowercase stopwords to check and/or remove from slug
	 */
	return $stopwords;
}

/**
 * Check whether the stopword appears in the string
 *
 * @param string $haystack    The string to be checked for the stopword.
 * @param bool   $checkingUrl Whether or not we're checking a URL.
 *
 * @return bool|mixed
 */
function stopwords_check( $haystack, $checkingUrl = false ) {
	$stopWords = stopwords();

	if ( is_array( $stopWords ) && $stopWords !== array() ) {
		foreach ( $stopWords as $stopWord ) {
			// If checking a URL remove the single quotes.
			if ( $checkingUrl ) {
				$stopWord = str_replace( "'", '', $stopWord );
			}

			// Check whether the stopword appears as a whole word.
			// @todo [JRF => whomever] check whether the use of \b (=word boundary) would be more efficient ;-).
			$res = preg_match( "`(^|[ \n\r\t\.,'\(\)\"\+;!?:])" . preg_quote( $stopWord, '`' ) . "($|[ \n\r\t\.,'\(\)\"\+;!?:])`iu", $haystack );
			if ( $res > 0 ) {
				return $stopWord;
			}
		}
	}

	return false;
}

/**
 * Clean up the input string.
 *
 * @param string $inputString              String to clean up.
 * @param bool   $removeOptionalCharacters Whether or not to do a cleanup of optional chars too.
 *
 * @return string
 */
function strip_separators_and_fold( $inputString, $removeOptionalCharacters = false ) {
	$keywordCharactersAlwaysReplacedBySpace = array( ',', "'", '"', '?', '’', '“', '”', '|', '/' );
	$keywordCharactersRemovedOrReplaced     = array( '_', '-' );
	$keywordWordsRemoved                    = array( ' una ', ' un ', ' una ', ' un ', ' para ', ' el ', ' y ' );

	// Lower.
	$inputString = strtolower_utf8( $inputString );

	// Default characters replaced by space.
	$inputString = str_replace( $keywordCharactersAlwaysReplacedBySpace, ' ', $inputString );

	// Standardise whitespace.
	$inputString = standardize_whitespace( $inputString );

	// Deal with the separators that can be either removed or replaced by space.
	if ( $removeOptionalCharacters ) {
		// Remove word separators with a space.
		$inputString = str_replace( $keywordWordsRemoved, ' ', $inputString );

		$inputString = str_replace( $keywordCharactersRemovedOrReplaced, '', $inputString );
	}
	else {
		$inputString = str_replace( $keywordCharactersRemovedOrReplaced, ' ', $inputString );
	}

	// Standardise whitespace again.
	$inputString = standardize_whitespace( $inputString );

	return trim( $inputString );
}

/**
 * Trim whitespace and NBSP (Non-breaking space) from string
 *
 * @param string $string
 *
 * @return string
 */
function trim_nbsp_from_string( $string ) {
	$find   = array( '&nbsp;', chr( 0xC2 ) . chr( 0xA0 ) );
	$string = str_replace( $find, ' ', $string );
	$string = trim( $string );

	return $string;
}

function strip_shortcode( $text ) {
	return preg_replace( '`\[[^\]]+\]`s', '', $text );
}

/**
 * Retrieve the body from the post.
 *
 * @param object $post The post object.
 *
 * @return string The post content.
 */
function get_body( $post_content ) {
	// Strip shortcodes, for obvious reasons, if plugins think their content should be in the analysis, they should
	// hook into the above filter.
	$post_content = trim_nbsp_from_string( strip_shortcode( $post_content ) );

	if ( trim( $post_content ) == '' ) {
		return '';
	}

	$htmdata3 = preg_replace( '`<(?:\x20*script|script).*?(?:/>|/script>)`', '', $post_content );
	if ( $htmdata3 == null ) {
		$htmdata3 = $post_content;
	}
	else {
		unset( $post_content );
	}

	$htmdata4 = preg_replace( '`<!--.*?-->`', '', $htmdata3 );
	if ( $htmdata4 == null ) {
		$htmdata4 = $htmdata3;
	}
	else {
		unset( $htmdata3 );
	}

	$htmdata5 = preg_replace( '`<(?:\x20*style|style).*?(?:/>|/style>)`', '', $htmdata4 );
	if ( $htmdata5 == null ) {
		$htmdata5 = $htmdata4;
	}
	else {
		unset( $htmdata4 );
	}

	return $htmdata5;
}

/**
 * Separate HTML elements and comments from the text.
 *
 * @since 4.2.4
 *
 * @param string $input The text which has to be formatted.
 * @return array The formatted text.
 */
function wp_html_split( $input ) {
	static $regex;

	if ( ! isset( $regex ) ) {
		$comments =
			  '!'           // Start of comment, after the <.
			. '(?:'         // Unroll the loop: Consume everything until --> is found.
			.     '-(?!->)' // Dash not followed by end of comment.
			.     '[^\-]*+' // Consume non-dashes.
			. ')*+'         // Loop possessively.
			. '(?:-->)?';   // End of comment. If not found, match all input.

		$cdata =
			  '!\[CDATA\['  // Start of comment, after the <.
			. '[^\]]*+'     // Consume non-].
			. '(?:'         // Unroll the loop: Consume everything until ]]> is found.
			.     '](?!]>)' // One ] not followed by end of comment.
			.     '[^\]]*+' // Consume non-].
			. ')*+'         // Loop possessively.
			. '(?:]]>)?';   // End of comment. If not found, match all input.

		$regex =
			  '/('              // Capture the entire match.
			.     '<'           // Find start of element.
			.     '(?(?=!--)'   // Is this a comment?
			.         $comments // Find end of comment.
			.     '|'
			.         '(?(?=!\[CDATA\[)' // Is this a comment?
			.             $cdata // Find end of comment.
			.         '|'
			.             '[^>]*>?' // Find end of element. If not found, match all input.
			.         ')'
			.     ')'
			. ')/s';
	}

	return preg_split( $regex, $input, -1, PREG_SPLIT_DELIM_CAPTURE );
}

/**
 * Replace characters or phrases within HTML elements only.
 *
 * @since 4.2.3
 *
 * @param string $haystack The text which has to be formatted.
 * @param array $replace_pairs In the form array('from' => 'to', ...).
 * @return string The formatted text.
 */
function wp_replace_in_html_tags( $haystack, $replace_pairs ) {
	// Find all elements.
	$textarr = wp_html_split( $haystack );
	$changed = false;

	// Optimize when searching for one item.
	if ( 1 === count( $replace_pairs ) ) {
		// Extract $needle and $replace.
		foreach ( $replace_pairs as $needle => $replace );

		// Loop through delimeters (elements) only.
		for ( $i = 1, $c = count( $textarr ); $i < $c; $i += 2 ) { 
			if ( false !== strpos( $textarr[$i], $needle ) ) {
				$textarr[$i] = str_replace( $needle, $replace, $textarr[$i] );
				$changed = true;
			}
		}
	} else {
		// Extract all $needles.
		$needles = array_keys( $replace_pairs );

		// Loop through delimeters (elements) only.
		for ( $i = 1, $c = count( $textarr ); $i < $c; $i += 2 ) { 
			foreach ( $needles as $needle ) {
				if ( false !== strpos( $textarr[$i], $needle ) ) {
					$textarr[$i] = strtr( $textarr[$i], $replace_pairs );
					$changed = true;
					// After one strtr() break out of the foreach loop and look at next element.
					break;
				}
			}
		}
	}

	if ( $changed ) {
		$haystack = implode( $textarr );
	}

	return $haystack;
}

/**
 * Replaces double line-breaks with paragraph elements.
 *
 * A group of regex replaces used to identify text formatted with newlines and
 * replace double line-breaks with HTML paragraph tags. The remaining line-breaks
 * after conversion become <<br />> tags, unless $br is set to '0' or 'false'.
 *
 * @since 0.71
 *
 * @param string $pee The text which has to be formatted.
 * @param bool   $br  Optional. If set, this will convert all remaining line-breaks
 *                    after paragraphing. Default true.
 * @return string Text which has been converted into correct paragraph tags.
 */
function wpautop($pee, $br = true) {
	$pre_tags = array();

	if ( trim($pee) === '' )
		return '';

	// Just to make things a little easier, pad the end.
	$pee = $pee . "\n";

	/*
	 * Pre tags shouldn't be touched by autop.
	 * Replace pre tags with placeholders and bring them back after autop.
	 */
	if ( strpos($pee, '<pre') !== false ) {
		$pee_parts = explode( '</pre>', $pee );
		$last_pee = array_pop($pee_parts);
		$pee = '';
		$i = 0;

		foreach ( $pee_parts as $pee_part ) {
			$start = strpos($pee_part, '<pre');

			// Malformed html?
			if ( $start === false ) {
				$pee .= $pee_part;
				continue;
			}

			$name = "<pre wp-pre-tag-$i></pre>";
			$pre_tags[$name] = substr( $pee_part, $start ) . '</pre>';

			$pee .= substr( $pee_part, 0, $start ) . $name;
			$i++;
		}

		$pee .= $last_pee;
	}
	// Change multiple <br>s into two line breaks, which will turn into paragraphs.
	$pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);

	$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';

	// Add a single line break above block-level opening tags.
	$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);

	// Add a double line break below block-level closing tags.
	$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);

	// Standardize newline characters to "\n".
	$pee = str_replace(array("\r\n", "\r"), "\n", $pee);

	// Find newlines in all elements and add placeholders.
	$pee = wp_replace_in_html_tags( $pee, array( "\n" => " <!-- wpnl --> " ) );

	// Collapse line breaks before and after <option> elements so they don't get autop'd.
	if ( strpos( $pee, '<option' ) !== false ) {
		$pee = preg_replace( '|\s*<option|', '<option', $pee );
		$pee = preg_replace( '|</option>\s*|', '</option>', $pee );
	}

	/*
	 * Collapse line breaks inside <object> elements, before <param> and <embed> elements
	 * so they don't get autop'd.
	 */
	if ( strpos( $pee, '</object>' ) !== false ) {
		$pee = preg_replace( '|(<object[^>]*>)\s*|', '$1', $pee );
		$pee = preg_replace( '|\s*</object>|', '</object>', $pee );
		$pee = preg_replace( '%\s*(</?(?:param|embed)[^>]*>)\s*%', '$1', $pee );
	}

	/*
	 * Collapse line breaks inside <audio> and <video> elements,
	 * before and after <source> and <track> elements.
	 */
	if ( strpos( $pee, '<source' ) !== false || strpos( $pee, '<track' ) !== false ) {
		$pee = preg_replace( '%([<\[](?:audio|video)[^>\]]*[>\]])\s*%', '$1', $pee );
		$pee = preg_replace( '%\s*([<\[]/(?:audio|video)[>\]])%', '$1', $pee );
		$pee = preg_replace( '%\s*(<(?:source|track)[^>]*>)\s*%', '$1', $pee );
	}

	// Remove more than two contiguous line breaks.
	$pee = preg_replace("/\n\n+/", "\n\n", $pee);

	// Split up the contents into an array of strings, separated by double line breaks.
	$pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);

	// Reset $pee prior to rebuilding.
	$pee = '';

	// Rebuild the content as a string, wrapping every bit with a <p>.
	foreach ( $pees as $tinkle ) {
		$pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
	}

	// Under certain strange conditions it could create a P of entirely whitespace.
	$pee = preg_replace('|<p>\s*</p>|', '', $pee); 

	// Add a closing <p> inside <div>, <address>, or <form> tag if missing.
	$pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
	
	// If an opening or closing block element tag is wrapped in a <p>, unwrap it.
	$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); 
	
	// In some cases <li> may get wrapped in <p>, fix them.
	$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); 
	
	// If a <blockquote> is wrapped with a <p>, move it inside the <blockquote>.
	$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
	$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
	
	// If an opening or closing block element tag is preceded by an opening <p> tag, remove it.
	$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
	
	// If an opening or closing block element tag is followed by a closing <p> tag, remove it.
	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);

	// Optionally insert line breaks.
	if ( $br ) {
		// Replace newlines that shouldn't be touched with a placeholder.
		$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', '_autop_newline_preservation_helper', $pee);

		// Replace any new line characters that aren't preceded by a <br /> with a <br />.
		$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); 

		// Replace newline placeholders with newlines.
		$pee = str_replace('<WPPreserveNewline />', "\n", $pee);
	}

	// If a <br /> tag is after an opening or closing block tag, remove it.
	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
	
	// If a <br /> tag is before a subset of opening or closing block tags, remove it.
	$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
	$pee = preg_replace( "|\n</p>$|", '</p>', $pee );

	// Replace placeholder <pre> tags with their original content.
	if ( !empty($pre_tags) )
		$pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);

	// Restore newlines in all elements.
	$pee = str_replace( " <!-- wpnl --> ", "\n", $pee );

	return $pee;
}

function get_first_paragraph( $body ) {
	// To determine the first paragraph we first need to autop the content, then match the first paragraph and return.
	$body_sintags = strip_tags($body);
	$body_sintags = nl2br($body_sintags);
	$pos = strpos($body_sintags, "<br />");
	if ($pos === false) {
		return strip_tags($body);
	}else{
		return substr($body_sintags, 0, $pos);
	}

	return false;
}

/**
 * Trims, removes line breaks, multiple spaces and generally cleans text before processing.
 *
 * @param string $strText Text to be transformed.
 *
 * @return string
 */
function clean_text( $strText ) {
	$clean = array();

	$key = sha1( $strText );

	if ( isset( $clean[ $key ] ) ) {
		return $clean[ $key ];
	}

	// All these tags should be preceeded by a full stop.
	$fullStopTags = array( 'li', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'dd' );
	foreach ( $fullStopTags as $tag ) {
		$strText = str_ireplace( '</' . $tag . '>', '.', $strText );
	}
	$strText = strip_tags( $strText );
	$strText = preg_replace( '`[",:;\(\)-]`', ' ', $strText ); // Replace commas, hyphens etc (count them as spaces).
	$strText = preg_replace( '`[\.!?]`', '.', $strText ); // Unify terminators.
	$strText = trim( $strText ) . '.'; // Add final terminator, just in case it's missing.
	$strText = preg_replace( '`[ ]*(\n|\r\n|\r)[ ]*`', ' ', $strText ); // Replace new lines with spaces.
	$strText = preg_replace( '`([\.])[\. ]+`', '$1', $strText ); // Check for duplicated terminators.
	$strText = trim( preg_replace( '`[ ]*([\.])`', '$1 ', $strText ) ); // Pad sentence terminators.
	$strText = preg_replace( '` [0-9]+ `', ' ', ' ' . $strText . ' ' ); // Remove "words" comprised only of numbers.
	$strText = preg_replace( '`[ ]+`', ' ', $strText ); // Remove multiple spaces.
	$strText = preg_replace_callback( '`\. [^ ]+?`', create_function( '$matches', 'return strtolower( $matches[0] );' ), $strText ); // Lower case all words following terminators (for gunning fog score).

	$strText = trim( $strText );

	// Cache it and return.
	$clean[ $key ] = $strText;

	return $strText;
}

/**
 * Gives string length.
 *
 * @param  string $strText Text to be measured.
 *
 * @return int
 */
$blnMbstring = true;

function text_length( $strText ) {
	if ( ! $blnMbstring ) {
		return strlen( $strText );
	}

	try {
		if ( $strEncoding == '' ) {
			$intTextLength = mb_strlen( $strText );
		}
		else {
			$intTextLength = mb_strlen( $strText, $strEncoding );
		}
	} catch ( Exception $e ) {
		$intTextLength = strlen( $strText );
	}

	return $intTextLength;
}

/**
 * Returns word count for text.
 *
 * @param  string $strText Text to be measured.
 *
 * @return int
 */
function word_count( $strText ) {
	if ( strlen( trim( $strText ) ) == 0 ) {
		return 0;
	}

	$strText = clean_text( $strText );
	// Will be tripped by em dashes with spaces either side, among other similar characters.
	$intWords = ( 1 + text_length( preg_replace( '`[^ ]`', '', $strText ) ) ); // Space count + 1 is word count.
	return $intWords;
}

/**
 * Do simple reliable math calculations without the risk of wrong results
 *
 * @see   http://floating-point-gui.de/
 * @see   the big red warning on http://php.net/language.types.float.php
 *
 * In the rare case that the bcmath extension would not be loaded, it will return the normal calculation results
 *
 * @static
 *
 * @since 1.5.0
 *
 * @param mixed  $number1   Scalar (string/int/float/bool).
 * @param string $action    Calculation action to execute. Valid input:
 *                            '+' or 'add' or 'addition',
 *                            '-' or 'sub' or 'subtract',
 *                            '*' or 'mul' or 'multiply',
 *                            '/' or 'div' or 'divide',
 *                            '%' or 'mod' or 'modulus'
 *                            '=' or 'comp' or 'compare'.
 * @param mixed  $number2   Scalar (string/int/float/bool).
 * @param bool   $round     Whether or not to round the result. Defaults to false.
 *                          Will be disregarded for a compare operation.
 * @param int    $decimals  Decimals for rounding operation. Defaults to 0.
 * @param int    $precision Calculation precision. Defaults to 10.
 *
 * @return mixed            Calculation Result or false if either or the numbers isn't scalar or
 *                          an invalid operation was passed
 *                          - for compare the result will always be an integer
 *                          - for all other operations, the result will either be an integer (preferred)
 *                            or a float
 */
function calc( $number1, $action, $number2, $round = false, $decimals = 0, $precision = 10 ) {
	static $bc;

	if ( ! is_scalar( $number1 ) || ! is_scalar( $number2 ) ) {
		return false;
	}

	if ( ! isset( $bc ) ) {
		$bc = extension_loaded( 'bcmath' );
	}

	if ( $bc ) {
		$number1 = number_format( $number1, 10, '.', '' );
		$number2 = number_format( $number2, 10, '.', '' );
	}

	$result  = null;
	$compare = false;

	switch ( $action ) {
		case '+':
		case 'add':
		case 'addition':
			$result = ( $bc ) ? bcadd( $number1, $number2, $precision ) /* string */ : ( $number1 + $number2 );
			break;

		case '-':
		case 'sub':
		case 'subtract':
			$result = ( $bc ) ? bcsub( $number1, $number2, $precision ) /* string */ : ( $number1 - $number2 );
			break;

		case '*':
		case 'mul':
		case 'multiply':
			$result = ( $bc ) ? bcmul( $number1, $number2, $precision ) /* string */ : ( $number1 * $number2 );
			break;

		case '/':
		case 'div':
		case 'divide':
			if ( $bc ) {
				$result = bcdiv( $number1, $number2, $precision ); // String, or NULL if right_operand is 0.
			}
			elseif ( $number2 != 0 ) {
				$result = ( $number1 / $number2 );
			}

			if ( ! isset( $result ) ) {
				$result = 0;
			}
			break;

		case '%':
		case 'mod':
		case 'modulus':
			if ( $bc ) {
				$result = bcmod( $number1, $number2, $precision ); // String, or NULL if modulus is 0.
			}
			elseif ( $number2 != 0 ) {
				$result = ( $number1 % $number2 );
			}

			if ( ! isset( $result ) ) {
				$result = 0;
			}
			break;

		case '=':
		case 'comp':
		case 'compare':
			$compare = true;
			if ( $bc ) {
				$result = bccomp( $number1, $number2, $precision ); // Returns int 0, 1 or -1.
			}
			else {
				$result = ( $number1 == $number2 ) ? 0 : ( ( $number1 > $number2 ) ? 1 : - 1 );
			}
			break;
	}

	if ( isset( $result ) ) {
		if ( $compare === false ) {
			if ( $round === true ) {
				$result = round( floatval( $result ), $decimals );
				if ( $decimals === 0 ) {
					$result = (int) $result;
				}
			}
			else {
				$result = ( intval( $result ) == $result ) ? intval( $result ) : floatval( $result );
			}
		}

		return $result;
	}

	return false;
}

/**
 * Normalizes score according to min & max allowed. If score larger
 * than max, max is returned. If score less than min, min is returned.
 * Also rounds result to specified precision.
 * Thanks to github.com/lvil.
 *
 * @param    int|float $score Initial score.
 * @param    int       $min   Minimum score allowed.
 * @param    int       $max   Maximum score allowed.
 * @param    int       $dps   Round to # decimals.
 *
 * @return    int|float
 */
function normalize_score( $score, $min, $max, $dps = 1 ) {
	$normalize = true;
	$score = calc( $score, '+', 0, true, $dps ); // Round.
	if ( ! $normalize ) {
		return $score;
	}

	if ( $score > $max ) {
		$score = $max;
	}
	elseif ( $score < $min ) {
		$score = $min;
	}

	return $score;
}

/**
 * Gives the Flesch-Kincaid Reading Ease of text entered rounded to one digit
 *
 * @param  string $strText Text to be checked.
 *
 * @return int|float
 */
function flesch_kincaid_reading_ease( $strText ) {
	$strText = clean_text( $strText );
	$score   = calc( calc( 206.835, '-', calc( 1.015, '*', average_words_per_sentence( $strText ) ) ), '-', calc( 84.6, '*', average_syllables_per_word( $strText ) ) );

	return normalize_score( $score, 0, 100 );
}

/**
 * Returns average syllables per word for text.
 *
 * @param string $strText Text to be measured.
 *
 * @return int|float
 */
function average_syllables_per_word( $strText ) {
	$strText          = clean_text( $strText );
	$intSyllableCount = 0;
	$intWordCount     = word_count( $strText );
	$arrWords         = explode( ' ', $strText );
	for ( $i = 0; $i < $intWordCount; $i ++ ) {
		$intSyllableCount += syllable_count( $arrWords[ $i ] );
	}

	return ( calc( $intSyllableCount, '/', $intWordCount ) );
}

function lower_case( $strText ) {

	if ( ! $blnMbstring ) {
		return strtolower( $strText );
	}

	try {
		if ( $strEncoding == '' ) {
			$strLowerCaseText = mb_strtolower( $strText );
		}
		else {
			$strLowerCaseText = mb_strtolower( $strText, $strEncoding );
		}
	} catch ( Exception $e ) {
		$strLowerCaseText = strtolower( $strText );
	}

	return $strLowerCaseText;
}

/**
 * Returns the number of syllables in the word.
 * Based in part on Greg Fast's Perl module Lingua::EN::Syllables
 *
 * @param string $strWord Word to be measured.
 *
 * @return int
 */
function syllable_count( $strWord ) {
	if ( strlen( trim( $strWord ) ) == 0 ) {
		return 0;
	}

	// Should be no non-alpha characters.
	$strWord = preg_replace( '`[^A-Za-z]`', '', $strWord );

	$intSyllableCount = 0;
	$strWord          = lower_case( $strWord );

	// Specific common exceptions that don't follow the rule set below are handled individually.
	// Array of problem words (with word as key, syllable count as value).
	$arrProblemWords = array(
		'simile'    => 3,
		'forever'   => 3,
		'shoreline' => 2,
	);
	if ( isset( $arrProblemWords[ $strWord ] ) ) {
		$intSyllableCount = $arrProblemWords[ $strWord ];
	}
	if ( $intSyllableCount > 0 ) {
		return $intSyllableCount;
	}

	// These syllables would be counted as two but should be one.
	$arrSubSyllables = array(
		'cial',
		'tia',
		'cius',
		'cious',
		'giu',
		'ion',
		'iou',
		'sia$',
		'[^aeiuoyt]{2,}ed$',
		'.ely$',
		'[cg]h?e[rsd]?$',
		'rved?$',
		'[aeiouy][dt]es?$',
		'[aeiouy][^aeiouydt]e[rsd]?$',
		// Sorts out deal, deign etc.
		'^[dr]e[aeiou][^aeiou]+$',
		// Purse, hearse.
		'[aeiouy]rse$',
	);

	// These syllables would be counted as one but should be two.
	$arrAddSyllables = array(
		'ia',
		'riet',
		'dien',
		'iu',
		'io',
		'ii',
		'[aeiouym]bl$',
		'[aeiou]{3}',
		'^mc',
		'ism$',
		'([^aeiouy])\1l$',
		'[^l]lien',
		'^coa[dglx].',
		'[^gq]ua[^auieo]',
		'dnt$',
		'uity$',
		'ie(r|st)$',
	);

	// Single syllable prefixes and suffixes.
	$arrPrefixSuffix = array(
		'`^un`',
		'`^fore`',
		'`ly$`',
		'`less$`',
		'`ful$`',
		'`ers?$`',
		'`ings?$`',
	);

	// Remove prefixes and suffixes and count how many were taken.
	$strWord = preg_replace( $arrPrefixSuffix, '', $strWord, - 1, $intPrefixSuffixCount );

	// Removed non-word characters from word.
	$strWord          = preg_replace( '`[^a-z]`is', '', $strWord );
	$arrWordParts     = preg_split( '`[^aeiouy]+`', $strWord );
	$intWordPartCount = 0;
	foreach ( $arrWordParts as $strWordPart ) {
		if ( $strWordPart <> '' ) {
			$intWordPartCount ++;
		}
	}

	// Some syllables do not follow normal rules - check for them.
	// Thanks to Joe Kovar for correcting a bug in the following lines.
	$intSyllableCount = ( $intWordPartCount + $intPrefixSuffixCount );
	foreach ( $arrSubSyllables as $strSyllable ) {
		$intSyllableCount -= preg_match( '`' . $strSyllable . '`', $strWord );
	}
	foreach ( $arrAddSyllables as $strSyllable ) {
		$intSyllableCount += preg_match( '`' . $strSyllable . '`', $strWord );
	}
	$intSyllableCount = ( $intSyllableCount == 0 ) ? 1 : $intSyllableCount;

	return $intSyllableCount;
}

/**
 * Returns average words per sentence for text.
 *
 * @param string $strText Text to be measured.
 *
 * @return int|float
 */
function average_words_per_sentence( $strText ) {
	$strText          = clean_text( $strText );
	$intSentenceCount = sentence_count( $strText );
	$intWordCount     = word_count( $strText );

	return ( calc( $intWordCount, '/', $intSentenceCount ) );
}

/**
 * Returns sentence count for text.
 *
 * @param   string $strText Text to be measured.
 *
 * @return int
 */
function sentence_count( $strText ) {
	if ( strlen( trim( $strText ) ) == 0 ) {
		return 0;
	}

	$strText = clean_text( $strText );
	// Will be tripped up by "Mr." or "U.K.". Not a major concern at this point.
	// [JRF] Will also be tripped up by ... or ?!
	// @todo [JRF => whomever] May be replace with something along the lines of this - will at least provide better count in ... and ?! situations:
	// $intSentences = max( 1, preg_match_all( '`[^\.!?]+[\.!?]+([\s]+|$)`u', $strText, $matches ) ); [/JRF].
	$intSentences = max( 1, text_length( preg_replace( '`[^\.!?]`', '', $strText ) ) );

	return $intSentences;
}

function aasort( &$array, $key ) {
	$sorter = array();
	$ret    = array();
	reset( $array );
	foreach ( $array as $ii => $va ) {
		$sorter[ $ii ] = $va[ $key ];
	}
	asort( $sorter );
	foreach ( $sorter as $ii => $va ) {
		$ret[ $ii ] = $array[ $ii ];
	}
	$array = $ret;
}

/**
 * Save the score result to the results array.
 *
 * @param array  $results      The results array used to store results.
 * @param int    $scoreValue   The score value.
 * @param string $scoreMessage The score message.
 * @param string $scoreLabel   The label of the score to use in the results array.
 * @param string $rawScore     The raw score, to be used by other filters.
 */
function save_score_result( &$results, $scoreValue, $scoreMessage, $scoreLabel, $rawScore = null ) {
	$score                  = array(
		'val' => $scoreValue,
		'msg' => $scoreMessage,
		'raw' => $rawScore,
	);
	$results[ $scoreLabel ] = $score;
}

/**
 * Check whether the keyword contains stopwords.
 *
 * @param string $keyword The keyword to check for stopwords.
 * @param array  $results The results array.
 */
function score_keyword( $keyword, &$results ) {
	$keywordStopWord = 'La palabra clave para esta página contiene una o más %sstop words%s, considera eliminarlas. Encontrado. \'%s\'.';
	if ( stopwords_check( $keyword ) !== false ) {
		save_score_result( $results, 5, sprintf( $keywordStopWord, '<a href="http://en.wikipedia.org/wiki/Stop_words">', '</a>', stopwords_check( $keyword ) ), 'keyword_stopwords' );
	}
}

/**
 * Check whether the keyword is contained in the title.
 *
 * @param array $job     The job array holding both the keyword versions.
 * @param array $results The results array.
 */
function score_title( $job, &$results ) {
	$scoreTitleMinLength    = 40;
	$scoreTitleMaxLength    = 70;
	$scoreTitleKeywordLimit = 0;

	$scoreTitleMissing          = 'Por favor, cree un título para la página.';
	$scoreTitleCorrectLength    = 'El título de la página tiene más de 40 caracteres y menos que el límite recomendado de 70 caracteres.';
	$scoreTitleTooShort         = 'El título de la página contiene %d caracteres, menos que el mínimo recomendado de 40 caracteres. Usa el espacio para añadir variaciones de las palabras clave o para crear un "call-to-action" llamativo.';
	$scoreTitleTooLong          = 'El título de la página contiene %d caracteres, mayor que el máximo recomendado de 70 caracteres; algunas palabras no serán visibles para los usuarios en su perfil.';
	$scoreTitleKeywordMissing   = 'La palabra clave / frase %s no aparece en el título de la página.';
	$scoreTitleKeywordBeginning = 'El título de la página contiene la palabra clave / frase al comienzo lo cual se considera que mejora los rankings.';
	$scoreTitleKeywordEnd       = 'El título de la página contienen la palabra clave / frase, pero esta no aparece al comienzo; trata de moverla al comienzo';

	if ( $job['title'] == '' ) {
		save_score_result( $results, 1, $scoreTitleMissing, 'title' );
	}
	else {
		$job['title'] = strip_tags( $job['title'] );

		$length = text_length( $job['title'] );
		//$length = strlen( strip_tags( $job['title'] ) );
		if ( $length < $scoreTitleMinLength ) {
			save_score_result( $results, 6, sprintf( $scoreTitleTooShort, $length ), 'title_length' );
		}
		elseif ( $length > $scoreTitleMaxLength ) {
			save_score_result( $results, 6, sprintf( $scoreTitleTooLong, $length ), 'title_length' );
		}
		else {
			save_score_result( $results, 9, $scoreTitleCorrectLength, 'title_length' );
		}

		// @todo MA Keyword/Title matching is exact match with separators removed, but should extend to distributed match.
		$needle_position = stripos( $job['title'], $job['keyword_folded'] );

		if ( $needle_position === false ) {
			$needle_position = stripos( $job['title'], $job['keyword'] );
		}

		if ( $needle_position === false ) {
			save_score_result( $results, 2, sprintf( $scoreTitleKeywordMissing, $job['keyword_folded'] ), 'title_keyword' );
		}
		elseif ( $needle_position <= $scoreTitleKeywordLimit ) {
			save_score_result( $results, 9, $scoreTitleKeywordBeginning, 'title_keyword' );
		}
		else {
			save_score_result( $results, 6, $scoreTitleKeywordEnd, 'title_keyword' );
		}
	}
}

/**
 * Score the meta description for length and keyword appearance.
 *
 * @param array  $job         The array holding the keywords.
 * @param array  $results     The results array.
 * @param string $description The meta description.
 * @param int    $maxlength   The maximum length of the meta description.
 */
function score_description( $job, &$results, $description, $maxlength = 155 ) {
	$scoreDescriptionMinLength      = 120;
	$scoreDescriptionCorrectLength  = 'En la meta descripción especificada, considera lo siguiente: ¿Cómo se compara con la competencia? ¿Puede ser más atractivo?';
	$scoreDescriptionTooShort       = 'La meta descripción es inferior a 120 caracteres, sin embargo hay disponibles hasta %s caracteres. El espacio disponible para texto es menor que el habitual de %s caracteres, ya que Google incluirá también la fecha de publicación en el fragmento.';
	$scoreDescriptionTooLong        = 'La meta descripción especificada tiene más de %s caracteres, reducir ese número asegurará que la descripción completa sea visible. El espacio disponible para texto es menor que el habitual de 155 caracteres, ya que Google incluirá también la fecha de publicación en el fragmento.';
	$scoreDescriptionMissing        = 'No se ha especificado ninguna meta descripción.';
	$scoreDescriptionKeywordIn      = 'La descripción meta contiene la palabra clave / frase principal.';
	$scoreDescriptionKeywordMissing = 'Una descripción meta se ha especificado pero no contiene la palabra clave / frase objetivo.';

	$metaShorter = '';
	if ( $maxlength != 155 ) {
		$metaShorter = 'The available space is shorter than the usual 155 characters because Google will also include the publication date in the snippet.';
	}

	if ( $description == '' ) {
		save_score_result( $results, 1, $scoreDescriptionMissing, 'description_length' );
	}
	else {
		$length = text_length( $description );
		//$length = strlen( strip_tags( $description ) );

		if ( $length < $scoreDescriptionMinLength ) {
			save_score_result( $results, 6, sprintf( $scoreDescriptionTooShort, $maxlength, $metaShorter ), 'description_length' );
		}
		elseif ( $length <= $maxlength ) {
			save_score_result( $results, 9, $scoreDescriptionCorrectLength, 'description_length' );
		}
		else {
			save_score_result( $results, 6, sprintf( $scoreDescriptionTooLong, $maxlength, $metaShorter ), 'description_length' );
		}

		// @todo MA Keyword/Title matching is exact match with separators removed, but should extend to distributed match.
		$haystack1 = strip_separators_and_fold( $description, true );
		$haystack2 = strip_separators_and_fold( $description, false );
		if ( strrpos( $haystack1, $job['keyword_folded'] ) === false && strrpos( $haystack2, $job['keyword_folded'] ) === false ) {
			save_score_result( $results, 3, $scoreDescriptionKeywordMissing, 'description_keyword' );
		}
		else {
			save_score_result( $results, 9, $scoreDescriptionKeywordIn, 'description_keyword' );
		}
	}
}

/**
 * Score the body for length and keyword appearance.
 *
 * @param array  $job     The array holding the keywords.
 * @param array  $results The results array.
 * @param string $body    The body.
 * @param string $firstp  The first paragraph.
 */
function score_body( $job, &$results, $body, $firstp ) {
	$lengthScore = array(
		'good' => 300,
		'ok'   => 250,
		'poor' => 200,
		'bad'  => 100,
	);

	$scoreBodyGoodLength = 'Hay %d palabras contenidas en este texto, es más de %d palabras recomendadas mínimo.';
	$scoreBodyPoorLength = 'Hay %d palabras contenidas en este texto, esta por debajo del mínimo de %d palabras recomendadas. Agrega más contenido útil en este tópico para los lectores.';
	$scoreBodyOKLength   = 'Hay %d palabras contenidas en este texto, esto esta ligeramente por debajo de %d palabras mínimas recomendadas, agrega un poco más.';
	$scoreBodyBadLength  = 'Hay %d palabras contenidas en este texto. Es una cifra demasiado baja y debería incrementarse.';

	$scoreKeywordDensityLow  = 'La densidad de la palabra clave es de %s%%, es una cifra un poco baja, la palabra clave se encontró %s veces.';
	$scoreKeywordDensityHigh = 'La densidad de la palabra clave es de %s%%, ue se encuentra por encima del máximo sugerido 4.5%, la palabra clave se encontró %s veces.';
	$scoreKeywordDensityGood = 'La densidad de la palabra clave es de %s%%, y eso es algo genial, la palabra clave se encontró en %s ocasiones.';

	$scoreFirstParagraphLow  = 'La palabra clave no aparece en el primer párrafo del texto, asegúrase de que el tema del que habla el texto queda claro lo antes posible.';
	$scoreFirstParagraphHigh = 'La palabra clave aparece en el primer párrafo del texto..';

	$fleschurl   = '<a href="http://en.wikipedia.org/wiki/Flesch-Kincaid_readability_test#Flesch_Reading_Ease">Flesch Reading Ease</a>';
	//$fleschurl   = '<a href="http://en.wikipedia.org/wiki/Flesch-Kincaid_readability_test#Flesch_Reading_Ease">' . __( 'Flesch Reading Ease', 'wordpress-seo' ) . '</a>';
	$scoreFlesch = 'The copy scores %s in the %s test, which is considered %s to read. %s';

	// Replace images with their alt tags, then strip all tags.
	$body = preg_replace( '`<img(?:[^>]+)?alt="([^"]+)"(?:[^>]+)>`', '$1', $body );
	$body = strip_tags( $body );

	// Copy length check.
	$wordCount = word_count( $body );

	if ( $wordCount < $lengthScore['bad'] ) {
		save_score_result( $results, - 20, sprintf( $scoreBodyBadLength, $wordCount, $lengthScore['good'] ), 'body_length', $wordCount );
	}
	elseif ( $wordCount < $lengthScore['poor'] ) {
		save_score_result( $results, - 10, sprintf( $scoreBodyPoorLength, $wordCount, $lengthScore['good'] ), 'body_length', $wordCount );
	}
	elseif ( $wordCount < $lengthScore['ok'] ) {
		save_score_result( $results, 5, sprintf( $scoreBodyPoorLength, $wordCount, $lengthScore['good'] ), 'body_length', $wordCount );
	}
	elseif ( $wordCount < $lengthScore['good'] ) {
		save_score_result( $results, 7, sprintf( $scoreBodyOKLength, $wordCount, $lengthScore['good'] ), 'body_length', $wordCount );
	}
	else {
		save_score_result( $results, 9, sprintf( $scoreBodyGoodLength, $wordCount, $lengthScore['good'] ), 'body_length', $wordCount );
	}

	$body           = strtolower_utf8( $body );
	$job['keyword'] = strtolower_utf8( $job['keyword'] );

	$keywordWordCount = word_count( $job['keyword'] );

	if ( $keywordWordCount > 10 ) {
		save_score_result( $results, 0, 'Su palabra clave está por encima de las 10 palabras, una palabra clave debe ser más corta y contener sólo un término de búsqueda.', 'focus_keyword_length' );
	}
	else {
		// Keyword Density check.
		$keywordDensity = 0;
		if ( $wordCount > 100 ) {
			//No ha querido funcionar con "preg_match_all"
			//$keywordCount = preg_match_all( ' ' . preg_quote( $job['keyword'], '`' ) . ' \miu', $body, $matches );
			$keywordCount = substr_count($body, $job['keyword']);
			if ( ( $keywordCount > 0 && $keywordWordCount > 0 ) && $wordCount > $keywordCount ) {
				$keywordDensity = calc( calc( $keywordCount, '/', calc( $wordCount, '-', ( calc( calc( $keywordWordCount, '-', 1 ), '*', $keywordCount ) ) ) ), '*', 100, true, 2 );
			}
			if ( $keywordDensity < 1 ) {
				save_score_result( $results, 4, sprintf( $scoreKeywordDensityLow, $keywordDensity, $keywordCount ), 'keyword_density' );
			}
			elseif ( $keywordDensity > 4.5 ) {
				save_score_result( $results, - 50, sprintf( $scoreKeywordDensityHigh, $keywordDensity, $keywordCount ), 'keyword_density' );
			}
			else {
				save_score_result( $results, 9, sprintf( $scoreKeywordDensityGood, $keywordDensity, $keywordCount ), 'keyword_density' );
			}
		}
	}

	$firstp = strtolower_utf8( $firstp );

	// First Paragraph Test.
	// Check without /u modifier as well as /u might break with non UTF-8 chars.
	if ( preg_match( '`\b' . preg_quote( $job['keyword'], '`' ) . '\b`miu', $firstp ) || preg_match( '`\b' . preg_quote( $job['keyword'], '`' ) . '\b`mi', $firstp ) || preg_match( '`\b' . preg_quote( $job['keyword_folded'], '`' ) . '\b`miu', $firstp )
	) {
		save_score_result( $results, 9, $scoreFirstParagraphHigh, 'keyword_first_paragraph' );
	}
	else {
		save_score_result( $results, 3, $scoreFirstParagraphLow, 'keyword_first_paragraph' );
	}

	$lang = 'es';
	if ( substr( $lang, 0, 2 ) == 'en' && $wordCount > 100 ) {
		// Flesch Reading Ease check.
		$flesch = flesch_kincaid_reading_ease( $body );

		$note  = '';
		$level = '';
		$score = 1;
		if ( $flesch >= 90 ) {
			$level = 'very easy';
			$score = 9;
		}
		elseif ( $flesch >= 80 ) {
			$level = 'easy';
			$score = 9;
		}
		elseif ( $flesch >= 70 ) {
			$level = 'fairly easy';
			$score = 8;
		}
		elseif ( $flesch >= 60 ) {
			$level = 'OK';
			$score = 7;
		}
		elseif ( $flesch >= 50 ) {
			$level = 'fairly difficult';
			$note  = 'Try to make shorter sentences to improve readability.';
			$score = 6;
		}
		elseif ( $flesch >= 30 ) {
			$level = 'difficult';
			$note  = 'Try to make shorter sentences, using less difficult words to improve readability.';
			$score = 5;
		}
		elseif ( $flesch >= 0 ) {
			$level = 'very difficult';
			$note  = 'Try to make shorter sentences, using less difficult words to improve readability.';
			$score = 4;
		}
		save_score_result( $results, $score, sprintf( $scoreFlesch, $flesch, $fleschurl, $level, $note ), 'flesch_kincaid' );
	}
}

/**
 * Check whether the keyword is contained in the URL.
 *
 * @param array $job     The job array holding both the keyword and the URLs.
 * @param array $results The results array.
 */
function score_url( $job, &$results ) {
	$urlGood      = 'La palabra /frase clave aparece en la URL de esta página.';
	$urlMedium    = 'La palabra / clave no aparece en la URL de esta página.';
	//$urlStopWords = 'The slug for this page contains one or more <a href="http://en.wikipedia.org/wiki/Stop_words">stop words</a>, consider removing them.';
	$longSlug     = 'El slug para esta página es un poco largo, considera reducirlo.';

	$needle    = strip_separators_and_fold( str_replace("-", " ", CamellizarConGuiones( $job['keyword'] ) ) );
	$haystack1 = strip_separators_and_fold( $job['pageUrl'], true );
	$haystack2 = strip_separators_and_fold( $job['pageUrl'], false );

	if ( stripos( $haystack1, $needle ) || stripos( $haystack2, $needle ) ) {
		save_score_result( $results, 9, $urlGood, 'url_keyword' );
	}
	else {
		save_score_result( $results, 6, $urlMedium, 'url_keyword' );
	}

	// Check for Stop Words in the slug.
	//if ( $GLOBALS['wpseo_admin']->stopwords_check( $job['pageSlug'], true ) !== false ) {
	//	$this->save_score_result( $results, 5, $urlStopWords, 'url_stopword' );
	//}

	// Check if the slug isn't too long relative to the length of the keyword.
	//if ( ( text_length( $job['keyword'] ) + 20 ) < text_length( $job['pageSlug'] ) && 40 < text_length( $job['pageSlug'] ) ) {
	//	save_score_result( $results, 5, $longSlug, 'url_length' );
	//}
}

/**
 * Check whether the images alt texts contain the keyword.
 *
 * @param array $job     The job array holding both the keyword versions.
 * @param array $results The results array.
 * @param array $imgs    The array with images alt texts.
 */
function score_images_alt_text( $job, &$results, $imgs ) {
	$scoreImagesNoImages          = 'Ninguna imagen aparece en esta página, considera agregar algunas según corresponda.';
	$scoreImagesNoAlt             = 'Las imágenes en esta página no tienen etiquetas alt.';
	$scoreImagesAltKeywordIn      = 'Las imágenes en esta página contienen etiquetas alt con la palabra clave / frase objetivo.';
	$scoreImagesAltKeywordMissing = 'Las imágenes en esta página no tienen etiquetas alt que contengan su palabra clave/frase';

	if ( $imgs['count'] == 0 ) {
		save_score_result( $results, 3, $scoreImagesNoImages, 'images_alt' );
	}
	elseif ( count( $imgs['alts'] ) == 0 && $imgs['count'] != 0 ) {
		save_score_result( $results, 5, $scoreImagesNoAlt, 'images_alt' );
	}
	else {
		$found = false;
		foreach ( $imgs['alts'] as $alt ) {
			$haystack1 = strip_separators_and_fold( $alt, true );
			$haystack2 = strip_separators_and_fold( $alt, false );
			if ( strrpos( $haystack1, $job['keyword_folded'] ) !== false ) {
				$found = true;
			}
			elseif ( strrpos( $haystack2, $job['keyword_folded'] ) !== false ) {
				$found = true;
			}
		}
		unset( $alt, $haystack1, $haystack2 );

		if ( $found ) {
			save_score_result( $results, 9, $scoreImagesAltKeywordIn, 'images_alt' );
		}
		else {
			save_score_result( $results, 5, $scoreImagesAltKeywordMissing, 'images_alt' );
		}
	}
}

?>