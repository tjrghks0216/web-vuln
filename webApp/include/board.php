<?php

class Free_board
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // 글 작성
    public function input($arr)
    {
        $sql = "INSERT INTO free_board (id, subject, content, file, create_at) VALUES (
            :id, :subject, :content, :file, NOW()
        )";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $arr['id']);
        $stmt->bindParam(":subject", $arr['subject']);
        $stmt->bindParam(":content", $arr['content']);
        $stmt->bindParam(":files", $arr['file']);
        $stmt->execute();
    }
}