<?php

namespace App\Test\Controller;

use App\Entity\MandatGestionnaire;
use App\Repository\MandatGestionnaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MandatGestionnaireControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private MandatGestionnaireRepository $repository;
    private string $path = '/mandat/gestionnaire/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(MandatGestionnaire::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('MandatGestionnaire index');

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
            'mandat_gestionnaire[debutMandat]' => 'Testing',
            'mandat_gestionnaire[finMandat]' => 'Testing',
            'mandat_gestionnaire[lot]' => 'Testing',
        ]);

        self::assertResponseRedirects('/mandat/gestionnaire/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new MandatGestionnaire();
        $fixture->setDebutMandat('My Title');
        $fixture->setFinMandat('My Title');
        $fixture->setLot('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('MandatGestionnaire');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new MandatGestionnaire();
        $fixture->setDebutMandat('My Title');
        $fixture->setFinMandat('My Title');
        $fixture->setLot('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'mandat_gestionnaire[debutMandat]' => 'Something New',
            'mandat_gestionnaire[finMandat]' => 'Something New',
            'mandat_gestionnaire[lot]' => 'Something New',
        ]);

        self::assertResponseRedirects('/mandat/gestionnaire/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDebutMandat());
        self::assertSame('Something New', $fixture[0]->getFinMandat());
        self::assertSame('Something New', $fixture[0]->getLot());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new MandatGestionnaire();
        $fixture->setDebutMandat('My Title');
        $fixture->setFinMandat('My Title');
        $fixture->setLot('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/mandat/gestionnaire/');
    }
}
