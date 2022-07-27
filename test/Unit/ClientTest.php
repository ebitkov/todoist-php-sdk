<?php

namespace ebitkov\TodoistSDK\Test\Unit;

use ebitkov\TodoistSDK\API\Project;
use ebitkov\TodoistSDK\Collection\ProjectCollection;
use ebitkov\TodoistSDK\Test\ClientTestCase;

class ClientTest extends ClientTestCase
{
    public function testGetAllProjectsAndGetProject()
    {
        $client = self::getClient();

        // get all projects
        $projects = $client->getAllProjects();

        self::assertInstanceOf(ProjectCollection::class, $projects);
        self::assertIsIterable($projects);
        self::assertNotEmpty($projects);

        foreach ($projects as $project) {
            self::assertInstanceOf(Project::class, $project);

            // get project
            $project = $client->getProject($project->getId());
            self::assertInstanceOf(Project::class, $project);
        }
    }

    public function testCreateGetDeleteProject()
    {
        $client = self::getClient();

        // create project
        $project = $client->createNewProject(Project::new('Test-Project'));

        self::assertInstanceOf(Project::class, $project);

        // get project
        $id = $project->getId();
        $project = $client->getProject($id);

        self::assertInstanceOf(Project::class, $project);
        self::assertSame($id, $project->getId());
    }
}