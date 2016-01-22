<?php


namespace LeagueWrap\Dto;


class Message extends AbstractDto
{

	public function __construct(array $info)
	{
		foreach($info['translations'] as &$translation) {
			$translation = new Translation($translation);
		}
		parent::__construct($info);
	}

	/**
	 * @param $locale
	 * @return null|Translation
	 */
	public function getTranslationByLocale($locale) {
		foreach($this->translations as $translation) {
			if($translation->locale == $locale)
				return $translation;
		}
		return null;
	}

}