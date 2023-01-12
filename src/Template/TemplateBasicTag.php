<?php

namespace App\Template;

use App\Context\ApplicationContext;
use App\Entity\Learner;
use App\Entity\Lesson;
use App\Repository\InstructorRepository;
use App\Repository\LessonRepository;
use App\Repository\MeetingPointRepository;
use Exception;

/**
 * Class TemplateBasicTag
 *
 * Default class to handle tag notification
 * don't hesitate to duplicate or extend if needed
 */
class TemplateBasicTag implements TemplateTagHydrator
{
    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     * @throws Exception
     */
    public function getTagsData(array $data): array
    {
       $lesson = $data['lesson'] ?? null;
       if (!$lesson instanceof Lesson) {
          throw new Exception("A Lesson is required", 500);
       }

       $userEntity = $data['user'] ?? null;
          if (!$userEntity instanceof Learner) {
             $userEntity = ApplicationContext::getInstance()->getCurrentUser();
          }

        $lessonEntity = LessonRepository::getInstance()->getById($lesson->id);
        $meetingPointEntity = MeetingPointRepository::getInstance()->getById($lessonEntity->meetingPointId);
        $instructorEntity = InstructorRepository::getInstance()->getById($lessonEntity->instructorId);

        $aryTags = [
           self::LESSON_INSTRUCTOR_LINK => $instructorEntity->getLink(),
           self::LESSON_SUMMARY_HTML => $lessonEntity->renderHtml(),
           self::LESSON_SUMMARY => $lessonEntity->renderText(),
           self::LESSON_INSTRUCTOR_NAME => $instructorEntity->firstname,
           self::LESSON_MEETING_POINT => $meetingPointEntity->name,
           self::LESSON_START_DATE => $lessonEntity->startTime->format('d/m/Y'),
           self::LESSON_START_TIME => $lessonEntity->startTime->format('H:i'),
           self::LESSON_END_TIME => $lessonEntity->endTime->format('H:i'),
           self::USER_FIRST_NAME => $userEntity->getFormatedFirstname()
        ];

        return $aryTags;
    }
}
