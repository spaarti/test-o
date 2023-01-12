<?php

namespace App\Entity;

use DateTime;

class Lesson
{
    public function __construct(
        public readonly int $id,
        public readonly int $meetingPointId,
        public readonly int $instructorId,
        public readonly DateTime $startTime,
        public readonly DateTime $endTime,
    ) {
    }

    public function renderHtml(): string
    {
        return '<p>' . $this->id . '</p>';
    }

    public function renderText(): string
    {
        return (string) $this->id;
    }
}
