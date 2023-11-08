<?php

namespace App\Test\Controller;

use App\Entity\Gestionnaire;
use App\Repository\GestionnaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GestionnaireControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private GestionnaireRepository $repository;
    private string $path = '/gestionnaire/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Gestionnaire::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Gestionnaire index');

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
            'gestionnaire[nomGestionnaire]' => 'Testing',
            'gestionnaire[adresseGestionnaire]' => 'Testing',
        ]);

        self::assertResponseRedirects('/gestionnaire/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Gestionnaire();
        $fixture->setNomGestionnaire('My Title');
        $fixture->setAdresseGestionnaire('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Gestionnaire');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Gestionnaire();
        $fixture->setNomGestionnaire('My Title');
        $fixture->setAdresseGestionnaire('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'gestionnaire[nomGestionnaire]' => 'Something New',
            'gestionnaire[adresseGestionnaire]' => 'Something New',
        ]);

        self::assertResponseRedirects('/gestionnaire/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomGestionnaire());
        self::assertSame('Something New', $fixture[0]->getAdresseGestionnaire());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Gestionnaire();
        $fixture->setNomGestionnaire('My Title');
        $fixture->setAdresseGestionnaire('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/gestionnaire/');
    }
}
