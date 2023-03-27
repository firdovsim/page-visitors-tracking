<?php

namespace App\Services;

use PDO;

class VisitorTracker
{
    public function __construct(private readonly PDO $connection)
    {
    }

    public function getVisitorBy(array $data)
    {
        $stmt = $this
            ->connection
            ->prepare("SELECT * FROM visitors WHERE ip_address = :ip_address AND user_agent = :user_agent AND page_url = :page_url");
        $stmt->execute($data);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateVisitorById(string $id, array $data): void
    {
        $stmt = $this
            ->connection
            ->prepare("UPDATE visitors SET view_date = :view_date, views_count = views_count + 1 WHERE id = :id");
        $stmt->execute([
            'view_date' => $data['view_date'],
            'id' => $id
        ]);
    }

    public function createVisitor(array $data): void
    {
        $stmt = $this
            ->connection
            ->prepare("INSERT INTO visitors (
                        ip_address, 
                        user_agent, 
                        page_url, 
                        view_date, 
                        views_count
                  ) VALUES (
                        :ip_address, 
                        :user_agent, 
                        :page_url, 
                        :view_date, 
                        1
                    )");
        $stmt->execute($data);
    }
}