<?php


namespace LeagueWrap\Dto;

/**
 * Class Timeline
 * @package LeagueWrap\Dto
 * Timeline of a match
 */
class MatchTimeline extends AbstractDto
{
    /**
     * Set up the timeline.
     *
     * @param array $info
     */
    public function __construct(array $info)
    {
        if(isset($info['frames']))
        {
            $frames = [];
            foreach($info['frames'] as $key => $frame)
            {
                $frames[$key] = new TimelineFrame($frame);
            }
            $info['frames'] = $frames;
        }

        parent::__construct($info);
    }
}
