<?php


namespace LeagueWrap\Dto;


class TimelineFrame extends AbstractDto {

    /**
     * Set up the frame.
     *
     * @param array $info
     */
    public function __construct(array $info)
    {
        if(isset($info['participantFrames']))
        {
            $p_frames = [];
            foreach($info['participantFrames'] as $key => $frame)
            {
                $p_frames[intval($key)] = new TimelineParticipantFrame($frame);
            }
            $info['participantFrames'] = $p_frames;
        }

        if(isset($info['events']))
        {
            $events = [];
            foreach($info['events'] as $key => $event)
            {
                $events[$key] = new TimelineFrameEvent($event);
            }
            $info['events'] = $events;
        }

        parent::__construct($info);
    }

    /**
     * @param $id int participantId
     * @return TimelineParticipantFrame|Null
     */
    public function participantFrame($id)
    {
        if ( ! isset($this->info['participantFrames']))
        {
            // no participant information for this frame
            return null;
        }
        $participantframes = $this->info['participantFrames'];
        if (isset($participantframes[$id]))
        {
            return $participantframes[$id];
        }
        return null;
    }

}