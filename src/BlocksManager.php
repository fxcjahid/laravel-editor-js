<?php

namespace LaravelEditorJs;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class BlocksManager
{
	protected $data;

	public function __construct($data)
	{
		$this->data = json_decode($data);
	}

	public function getData()
	{
		return $this->data;
	}

	public function getBlocks()
	{
		return $this->data->blocks ?? [];
	}

	public function getTimestamp()
	{
		return $this->data->time;
	}

	public function getVersion()
	{
		return $this->data->version;
	}

	public function hasBlocks()
	{
		return (bool)count($this->getBlocks());
	}

	public function renderHtml()
	{
		$html = '';
		foreach ($this->getBlocks() as $block) {
			$html .= $this->renderHtmlBlock($block);
		}

		return $html;
	}

	public function renderText()
	{
		$text = '';
		foreach ($this->getBlocks() as $block) {
			$text .= $this->renderTextBlock($block);
		}

		$text = htmlspecialchars_decode($text); // Convert special HTML entities back to characters
		$text = trim($text); //Strip whitespace (or other characters) from the beginning and end of a string

		return $text;
	}

	public function renderHtmlBlock($block)
	{
		$viewName = "laravel-editor-js::blocks." . Str::snake($block->type, '-');

		if (!View::exists($viewName)) {
			$viewName = 'laravel-editor-js::blocks.not-found';
		}

		return View::make($viewName, [
			'data' => (array) $block
		])->render();
	}

	public function renderTextBlock($block)
	{
		$text = '';
		// Only accpect Header & Paragraph
		if (in_array($block->type, ['header', 'paragraph'])) {
			$text .= $block->data->text . " ";
		}

		return $text;
	}

	public function countChar()
	{
		$counter = 0;

		foreach ($this->data->blocks as $block) {
			if (in_array($block->type, ['embed', 'image']) && isset($block->data->caption)) {
				$counter += strlen($block->data->caption);
			} elseif ($block->type == 'list' && isset($block->data->items)) {
				foreach ($block->data->items as $item) {
					$counter += strlen($item);
				}
			} elseif (isset($block->data->text)) {
				$counter += strlen($block->data->text);
			}
		}

		return $counter;
	}
}