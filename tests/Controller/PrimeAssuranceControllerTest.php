<?php

namespace App\Test\Controller;

use App\Entity\PrimeAssurance;
use App\Repository\PrimeAssuranceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PrimeAssuranceControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PrimeAssuranceRepository $repository;
    private string $path = '/prime/assurance/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(PrimeAssurance::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PrimeAssurance index');

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
            'prime_assurance[annee]' => 'Testing',
            'prime_assurance[montant]' => 'Testing',
            'prime_assurance[lot]' => 'Testing',
        ]);

        self::assertResponseRedirects('/prime/assurance/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new PrimeAssurance();
        $fixture->setAnnee('My Title');
        $fixture->setMontant('My Title');
        $fixture->setLot('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PrimeAssurance');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new PrimeAssurance();
        $fixture->setAnnee('My Title');
        $fixture->setMontant('My Title');
        $fixture->setLot('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'prime_assurance[annee]' => 'Something New',
            'prime_assurance[montant]' => 'Something New',
            'prime_assurance[lot]' => 'Something New',
        ]);

        self::assertResponseRedirects('/prime/assurance/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getAnnee());
        self::assertSame('Something New', $fixture[0]->getMontant());
        self::assertSame('Something New', $fixture[0]->getLot());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new PrimeAssurance();
        $fixture->setAnnee('My Title');
        $fixture->setMontant('My Title');
        $fixture->setLot('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/prime/assurance/');
    }
}
