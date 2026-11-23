<?php
class About {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function getSections() {
        $query = "SELECT aboutId, title, content
                  FROM about
                  ORDER BY displayOrder, aboutId";
        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}