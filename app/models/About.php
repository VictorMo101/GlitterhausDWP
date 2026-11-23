<?php
class About {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getSections() {
        $query = "SELECT aboutId, title, content, displayOrder
                  FROM about
                  ORDER BY displayOrder, aboutId";
        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createSection($title, $content, $displayOrder) {
        $query = "INSERT INTO about (title, content, displayOrder)
                  VALUES (:title, :content, :displayOrder)";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ':title' => $title,
            ':content' => $content,
            ':displayOrder' => $displayOrder
        ]);
    }

    public function updateSection($aboutId, $title, $content, $displayOrder) {
        $query = "UPDATE about
                  SET title = :title, content = :content, displayOrder = :displayOrder
                  WHERE aboutId = :aboutId";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ':aboutId' => $aboutId,
            ':title' => $title,
            ':content' => $content,
            ':displayOrder' => $displayOrder
        ]);
    }

    public function deleteSection($aboutId) {
        $query = "DELETE FROM about WHERE aboutId = :aboutId";
        $statement = $this->connection->prepare($query);
        $statement->execute([':aboutId' => $aboutId]);
    }
}