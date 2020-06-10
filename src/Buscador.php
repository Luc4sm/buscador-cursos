<?php

namespace Alura\BuscadorCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    private $httpClient;
    private $crawlerClient;

    function __construct(ClientInterface $http, Crawler $crawler)
    {
        $this->httpClient = $http;    
        $this->crawlerClient = $crawler;    
    }
    
    public function buscar(string $url)
    {
        $resposta = $this->httpClient->request('GET', $url);

        $html = $resposta->getBody();
        
        $this->crawlerClient->addHtmlContent($html);
    
        $cursos = $this->crawlerClient->filter('span.card-curso__nome');

        $resultados = [];

        foreach ($cursos as $curso) {
            $resultados[] = $curso;
        }

        return $resultados;
    }


}