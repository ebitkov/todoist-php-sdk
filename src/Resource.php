<?php

namespace ebitkov\TodoistSDK;

class Resource
{
    public static function COLLABORATORS(?int $projectId = null): string
    {
        return self::PROJECTS($projectId) . '/collaborators';
    }

    public static function PROJECTS(?int $id = null): string
    {
        $ep = 'projects';
        if ($id !== null) {
            $ep .= '/' . $id;
        }
        return $ep;
    }

    public static function SECTIONS(?int $id = null): string
    {
        $ep = 'sections';
        if ($id !== null) {
            $ep .= '/' . $id;
        }
        return $ep;
    }

    public static function TASKS(?int $id = null): string
    {
        $ep = 'tasks';
        if ($id !== null) {
            $ep .= '/' . $id;
        }
        return $ep;
    }

    public static function COMMENTS(?int $id = null): string
    {
        $ep = 'comments';
        if ($id !== null) {
            $ep .= '/' . $id;
        }
        return $ep;
    }
}