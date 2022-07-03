<?php

namespace App\Test\Controller;

use App\Entity\Intervention;
use App\Repository\InterventionRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InterventionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private InterventionRepository $repository;
    private string $path = '/intervention/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Intervention::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Intervention index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'intervention[date]' => 'Testing',
            'intervention[startAt]' => 'Testing',
            'intervention[duration]' => 'Testing',
            'intervention[stopAt]' => 'Testing',
            'intervention[donePaid]' => 'Testing',
        ]);

        self::assertResponseRedirects('/intervention/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Intervention();
        $fixture->setDate('My Title');
        $fixture->setStartAt('My Title');
        $fixture->setDuration('My Title');
        $fixture->setStopAt('My Title');
        $fixture->setDonePaid('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Intervention');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Intervention();
        $fixture->setDate('My Title');
        $fixture->setStartAt('My Title');
        $fixture->setDuration('My Title');
        $fixture->setStopAt('My Title');
        $fixture->setDonePaid('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'intervention[date]' => 'Something New',
            'intervention[startAt]' => 'Something New',
            'intervention[duration]' => 'Something New',
            'intervention[stopAt]' => 'Something New',
            'intervention[donePaid]' => 'Something New',
        ]);

        self::assertResponseRedirects('/intervention/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getStartAt());
        self::assertSame('Something New', $fixture[0]->getDuration());
        self::assertSame('Something New', $fixture[0]->getStopAt());
        self::assertSame('Something New', $fixture[0]->getDonePaid());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Intervention();
        $fixture->setDate('My Title');
        $fixture->setStartAt('My Title');
        $fixture->setDuration('My Title');
        $fixture->setStopAt('My Title');
        $fixture->setDonePaid('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/intervention/');
    }
}
