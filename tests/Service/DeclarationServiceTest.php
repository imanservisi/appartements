<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\DeclarationService;

class DeclarationServiceTest extends TestCase
{
	public function testCreateYearsArrayReturnsFourYearsInAscendingOrder()
	{
		$service = new DeclarationService();
		$result = $service->createYearsArray();

		$this->assertIsArray($result, 'La méthode doit retourner un tableau.');
		$this->assertCount(4, $result, 'Le tableau doit contenir 4 années.');

		$currentYear = (int) date('Y');
		$expected = [];
		for ($i = 3; $i >= 0; $i--) {
			$expected[] = (string) ($currentYear - $i);
		}
		$this->assertSame($expected, $result, 'Les années doivent être du plus ancien au plus récent (chaînes).');
        $this->assertSame($result[3], (string) $currentYear);
	}
}
