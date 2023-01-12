<?php

namespace App\Template;

/**
 * Interface TemplateTagHydrator
 *
 * allow to extend hydrating strategies
 * Can provide new object to add more Tags
 * @package App
 */
interface TemplateTagHydrator
{
    public const LESSON_INSTRUCTOR_LINK = '[lesson:instructor_link]';
    public const LESSON_SUMMARY_HTML = '[lesson:summary_html]';
    public const LESSON_SUMMARY = '[lesson:summary]';
    public const LESSON_INSTRUCTOR_NAME = '[lesson:instructor_name]';
    public const LESSON_MEETING_POINT = '[lesson:meeting_point]';
    public const LESSON_START_DATE = '[lesson:start_date]';
    public const LESSON_START_TIME = '[lesson:start_time]';
    public const LESSON_END_TIME = '[lesson:end_time]';
    public const USER_FIRST_NAME = '[user:first_name]';

    /**
     * @param array<string, mixed> $data
     * @return array<string, string> // Key is a tag string, value is the replacement
     */
    public function getTagsData(array $data): array;
}
