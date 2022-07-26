<?php

namespace ebitkov\TodoistSDK\Test\Unit;

use Doctrine\Common\Collections\ArrayCollection;
use ebitkov\TodoistSDK\Client;
use ebitkov\TodoistSDK\Collection\ProjectCollection;
use ebitkov\TodoistSDK\Project;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{

    private $client;

    protected function setUp(): void
    {
        if (!empty($token = getenv('TODOIST_API_TOKEN'))) {
            $this->client = new Client($token);
        } else {
            $this->markTestSkipped('Please provide an API token via the environment variable TODOIST_API_TOKEN to execute this test.');
        }
    }

    public function testGetAllProjects()
    {
        $projects = $this->client->getAllProjects();

        self::assertInstanceOf(ProjectCollection::class, $projects);
        self::assertIsIterable($projects);
        self::assertNotEmpty($projects);

        foreach ($projects as $project) {
            self::assertInstanceOf(Project::class, $project);
        }
    }

    public function testCreateProject()
    {
        $project = $this->client->createNewProject(Project::new('Test-Project'));

        self::assertInstanceOf(Project::class, $project);
    }
}