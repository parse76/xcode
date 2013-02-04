<?php

class Template
{
	public $base_url;
	protected $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
		$this->base_url = base_url();
	}

	public function load($data, $json = FALSE)
	{
		if ($json == TRUE)
		{
			header('Content-type: application/json');
			echo json_encode($data['content']);
			exit();
		}

		$data['content']['base_url'] = $this->base_url;

		switch ($data['layout'])
		{
			case 'none':
				$this->none_template($data['content'], $data['page']);
				break;
			case 'default':
				$this->default_template($data['content'], $data['page']);
				break;
			case 'profile':
				$this->profile_template($data['content'], $data['page']);
				break;
		}
	}

	public function none_template($content, $page)
	{
		$this->ci->parser->parse('header', $content);
		$this->ci->parser->parse($page, $content);
		$this->ci->parser->parse('footer', $content);
	}

	public function default_template($content, $page)
	{
		$this->ci->parser->parse('header', $content);
		$this->ci->parser->parse('main/header_view', $content);
		$this->ci->parser->parse('main/banner_view', $content);
		$this->ci->parser->parse('main/navbar_view', $content);
		$this->ci->parser->parse($page, $content);
		$this->ci->parser->parse('main/footer_view', $content);
		$this->ci->parser->parse('footer', $content);
	}

	public function profile_template($content, $page)
	{
		$this->parser->parse('header', $content);
		$this->parser->parse($page, $content);
		$this->parser->parse('footer', $content);
	}
}