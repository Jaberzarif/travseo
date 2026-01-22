<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestDbController
{
    #[Route('/test-db', name: 'test_db')]
    public function test(Connection $connection): Response
    {
        try {
            $db = $connection->fetchOne('SELECT DATABASE()');
            return new Response('✅ Database connected: ' . $db);
        } catch (\Exception $e) {
            return new Response('❌ Database error: ' . $e->getMessage());
        }
    }
}
