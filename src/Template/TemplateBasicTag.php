<?php

namespace App\Template;

use App\Context\ApplicationContext;
use App\Entity\Instructor;
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
     * @return array<string, string> // Key is a tag string, value is the replacement
     * @throws Exception
     */
    public function getTagsData(array $data): array
    {
        $lessonEntity = $this->getLesson($data);
        $instructorEntity = $this->getInstructor($data, $lessonEntity->instructorId);
        $userEntity = $this->getUser($data);

        $aryTags = [
          self::LESSON_INSTRUCTOR_LINK => $instructorEntity->getLink(),
          self::LESSON_SUMMARY_HTML => $lessonEntity->renderHtml(),
          self::LESSON_SUMMARY => $lessonEntity->renderText(),
          self::LESSON_INSTRUCTOR_NAME => $instructorEntity->firstname,
          self::LESSON_START_DATE => $lessonEntity->startTime->format('d/m/Y'),
          self::LESSON_START_TIME => $lessonEntity->startTime->format('H:i'),
          self::LESSON_END_TIME => $lessonEntity->endTime->format('H:i'),
          self::USER_FIRST_NAME => $userEntity->getFormatedFirstname()
       ];

        if ($lessonEntity->meetingPointId) { // lesson with non existing meeting point is possible ? in case we avoid perf issue
            $meetingPointEntity = MeetingPointRepository::getInstance()->getById($lessonEntity->meetingPointId);
            $aryTags[self::LESSON_MEETING_POINT] = $meetingPointEntity->name;
        }

        return $aryTags;
    }

    /**
     * @param array<string, mixed> $data
     * @return Lesson
     * @throws Exception
     */
    private function getLesson(array $data): Lesson
    {
        $lesson = $data['lesson'] ?? null;
        if (!$lesson instanceof Lesson) {
            throw new Exception("A Lesson is required", 500);
        }

        // in our case this lesson query seem useless, renderHtml and text give us ID, already owned, left only for
        // compatibility purpuse.
        return LessonRepository::getInstance()->getById($lesson->id);
    }

    /**
     * @param array<string, mixed> $data
     * @return Learner
     * @throws Exception
     */
    private function getUser(array $data): Learner
    {
        $user = $data['user'] ?? null;
        if (!$user instanceof Learner) {
            $user = ApplicationContext::getInstance()->getCurrentUser();
        }

        if (!$user) {
            throw new Exception("An User is required", 500);
        }

        return $user;
    }

   /**
    * @param array<string, mixed> $data
    * @param int|null $instructorId
    * @return Instructor
    */
   private function getInstructor(array $data, ?int $instructorId = null): Instructor
   {
       $instructor = $data['instructor'] ?? null;
       if (!$instructor instanceof Instructor) {
           $instructor = InstructorRepository::getInstance()->getById($instructorId);
       }

       return $instructor;
   }
}
