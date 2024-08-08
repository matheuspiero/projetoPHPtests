<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Dao\Leilao as DaoLeilao;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Service\Encerrador;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class EncerradorTest extends TestCase
{
    public function testLeiloesComMaisDeUmaSemanaDevemSerEncerrados ()
    {
        $fiat147 = new Leilao(
            'Fiat 147 0km',
            new DateTimeImmutable('8 days ago')
        );
        $variant = new Leilao(
            'Variant 1972 0km',
            new DateTimeImmutable('10 days ago')
        );
        $leilaoDao = new DaoLeilao();
        $leilaoDao->salva($fiat147);
        $leilaoDao->salva($variant);

        $encerrador = new Encerrador();
        $encerrador->encerra();
        
        $leiloes = $leilaoDao->recuperarfinalizados();
        self::assertCount(2, $leiloes);
        self::assertEquals('Fiat 147 0km', $leiloes[0]->recuperarDescricao());
        self::assertEquals('Variant 1972 0km', $leiloes[0]->recuperarDescricao());
        
    }
}