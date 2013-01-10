<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Link
 *
 * Generates link to a CSS file
 *
 * @access	public
 * @param	mixed	stylesheet hrefs or an array
 * @param	string	rel
 * @param	string	type
 * @param	string	title
 * @param	string	media
 * @param	boolean	should index_page be added to the css path
 * @return	string
 */
if ( ! function_exists('link_tag'))
{
	function link_tag($href = '', $rel = 'stylesheet', $type = 'text/css', $title = '', $media = '', $index_page = FALSE)
	{
		$CI =& get_instance();

		$link = '<link ';

		if (is_array($href))
		{
			foreach ($href as $k=>$v)
			{
				if ($k == 'href' AND strpos($v, '://') === FALSE)
				{
					if ($index_page === TRUE)
					{
						$link .= 'href="'.$CI->config->site_url($v).'" ';
					}
					else
					{
						$link .= 'href="'.$CI->config->slash_item('base_url').$v.'" ';
					}
				}
				else
				{
					$link .= "$k=\"$v\" ";
				}
			}

			$link .= "/>\n";
		}
		else
		{
			if ( strpos($href, '://') !== FALSE)
			{
				$link .= 'href="'.$href.'" ';
			}
			elseif ($index_page === TRUE)
			{
				$link .= 'href="'.$CI->config->site_url($href).'" ';
			}
			else
			{
				$link .= 'href="'.$CI->config->slash_item('base_url').$href.'" ';
			}

			$link .= 'rel="'.$rel.'" type="'.$type.'" ';

			if ($media	!= '')
			{
				$link .= 'media="'.$media.'" ';
			}

			if ($title	!= '')
			{
				$link .= 'title="'.$title.'" ';
			}

			$link .= "/>\n";
		}


		return $link;
	}
}

/**
 * Script
 *
 * Generates link to a JS file
 *
 * @access	public
 * @param	mixed	scripts srcs or an array
 * @param	string	type
 * @param	boolean	should index_page be added to the css path
 * @return	string
 */
if ( ! function_exists('script_tag'))
{
	function script_tag($src = '', $type = 'text/javascript', $index_page = FALSE)
	{
		$CI =& get_instance();

		$script = '<script ';

		if (is_array($src))
		{
			foreach ($src as $k=>$v)
			{
				if ($k == 'src' AND strpos($v, '://') === FALSE)
				{
					if ($index_page === TRUE)
					{
						$script .= 'src="'.$CI->config->site_url($v).'" ';
					}
					else
					{
						$script .= 'src="'.$CI->config->slash_item('base_url').$v.'" ';
					}
				}
				else
				{
					$script .= "$k=\"$v\" ";
				}
			}

			$script .= "></script>\n";
		}
		else
		{
			if ( strpos($src, '://') !== FALSE)
			{
				$script .= 'src="'.$src.'" ';
			}
			elseif ($index_page === TRUE)
			{
				$script .= 'src="'.$CI->config->site_url($src).'" ';
			}
			else
			{
				$script .= 'src="'.$CI->config->slash_item('base_url').$src.'" ';
			}

			$script .= 'type="'.$type.'"';

			$script .= "></script>\n";
		}


		return $script;
	}
}