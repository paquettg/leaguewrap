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
            $pFrames = [];
            foreach($info['participantFrames'] as $key => $frame)
            {
                $pFrames[intval($key)] = new TimelineParticipantFrame($frame);
            }
            $info['participantFrames'] = $pFrames;
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
     * @param $participantId int 
     * @return TimelineParticipantFrame|Null
     */
    public function participantFrame($participantId)
    {
        if ( ! isset($this->info['participantFrames']))
        {
            // no participant information for this frame
            return null;
        }
        $participantframes = $this->info['participantFrames'];
        if (isset($participantframes[$participantId]))
        {
            return $participantframes[$participantId];
        }
        return null;
    }

}
