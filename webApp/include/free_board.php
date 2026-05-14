<?php

class Free_board
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function isValidDateFormat($date)
    {
        // 정규식 패턴: 'YYYY-MM-DD' 형식인지 확인
        $pattern = '/^\d{4}-\d{2}-\d{2}$/';

        // 패턴이 일치하는지 확인
        if (preg_match($pattern, $date)) {
            return true;
        } else {
            return false;
        }
    }

    // 글 작성
    public function input($arr)
    {
        if (isset($arr['file'])) {
            $sql = "INSERT INTO free_board (id, subject, content, create_at, file, file_type) VALUES (
                :id, :subject, :content, NOW(), :file, :file_type
            )";
        } else {
            $sql = "INSERT INTO free_board (id, subject, content, create_at) VALUES (
            :id, :subject, :content, NOW()
        )";

        }
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $arr['id']);
        $stmt->bindParam(":subject", $arr['subject']);
        $stmt->bindParam(":content", $arr['content']);
        if (isset($arr['file'])) {
            $stmt->bindParam(":file", $arr['file']);
            $stmt->bindParam(":file_type", $arr['file_type']);
        }
        $stmt->execute();

    }


    // 전체글 수 구하기
    public function total($paramArr)
    {
        $where = '';
        $params = [];
        if (isset($paramArr['sn']) && $paramArr['sn'] != '' && isset($paramArr['sf']) && $paramArr['sf'] != '') {
            switch ($paramArr['sn']) {
                case 1: // %:sf% 형태. 
                    $where .= "WHERE (subject LIKE CONCAT('%', :sf, '%') OR content LIKE CONCAT('%', :sf2, '%')) ";
                    $params = [':sf' => $paramArr['sf'], ':sf2' => $paramArr['sf']];
                    break; // 내용 + 제목 검색
                case 2:
                    $where .= "WHERE (subject LIKE CONCAT('%', :sf, '%')) ";
                    $params = [':sf' => $paramArr['sf']];
                    break; // 제목 검색
                case 3:
                    $where .= "WHERE (content LIKE CONCAT('%', :sf, '%')) ";
                    $params = [':sf' => $paramArr['sf']];
                    break; // 내용 검색
                case 4:
                    $where .= "WHERE (id=:sf)";
                    $params = [':sf' => $paramArr['sf']];
                    break; // 글쓴이 검색

            }
        }

        if ($paramArr['date_from'] != '' && $paramArr['date_to'] != '' && $this->isValidDateFormat($paramArr['date_from']) && $this->isValidDateFormat($paramArr['date_to'])) {
            if ($paramArr['sf'] == '') {
                $where .= "WHERE";
            } else {
                $where .= " and";
            }
            $where .= " create_at between '{$paramArr['date_from']}' and '{$paramArr['date_to']}' ";
        }


        $sql = "SELECT COUNT(*) AS cnt FROM free_board " . $where;
        $stmt = $this->conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute($params);
        $row = $stmt->fetch();
        return $row['cnt'];

    }


    // 글 목록
    public function list($page, $limit, $paramArr)
    {
        $start = ($page - 1) * $limit;
        $params = [];
        $where = '';
        $order = "idx DESC";
        if (isset($paramArr['sn']) && $paramArr['sn'] != '' && isset($paramArr['sf']) && $paramArr['sf'] != '') {
            switch ($paramArr['sn']) {
                case 1: // %:sf% 형태. 
                    $where .= "WHERE (subject LIKE CONCAT('%', :sf, '%') OR content LIKE CONCAT('%', :sf2, '%')) ";
                    $params = [':sf' => $paramArr['sf'], ':sf2' => $paramArr['sf']];
                    break; // 내용 + 제목 검색
                case 2:
                    $where .= "WHERE (subject LIKE CONCAT('%', :sf, '%')) ";
                    $params = [':sf' => $paramArr['sf']];
                    break; // 제목 검색
                case 3:
                    $where .= "WHERE (content LIKE CONCAT('%', :sf, '%')) ";
                    $params = [':sf' => $paramArr['sf']];
                    break; // 내용 검색
                case 4:
                    $where .= "WHERE (id=:sf)";
                    $params = [':sf' => $paramArr['sf']];
                    break; // 글쓴이 검색

            }
        }

        // 날짜 순 정렬
        if ($paramArr['date_from'] != '' && $paramArr['date_to'] != '' && $this->isValidDateFormat($paramArr['date_from']) && $this->isValidDateFormat($paramArr['date_to'])) {
            if ($paramArr['sf'] == '') {
                $where .= "WHERE";
            } else {
                $where .= " and";
            }
            $where .= " create_at between '{$paramArr['date_from']}' and '{$paramArr['date_to']}' ";
        }


        if ($paramArr['order'] != '') {
            $new_order = $paramArr['order'];
            if ($new_order == 'hit_asc') {  // 조회 순 정렬
                $order = 'hit asc';
            } else if ($new_order == 'hit_desc') {
                $order = 'hit desc';
            } else if ($new_order == 'likes_asc') { // 추천 순 정렬
                $order = 'likes asc';
            } else if ($new_order == 'likes_desc') {
                $order = 'likes desc';
            } else if ($new_order == 'subject_asc') { // 제목 순 정렬
                $order = 'subject asc';
            } else if ($new_order == 'subject_desc') {
                $order = 'subject desc';
            } else if ($new_order == 'create_at_asc') { // 날짜 순 정렬
                $order = 'create_at asc';
            } else if ($new_order == 'create_at_desc') {
                $order = 'create_at desc';
            }
        }


        // 회원관리 리스트를 출력하기 위해서 필요한 열만 사용
        $sql = "SELECT idx,id,subject,hit,likes,DATE_FORMAT(create_at, '%Y-%m-%d %H:%i') AS create_at FROM free_board " . $where . "ORDER BY {$order} LIMIT " . $start . "," . $limit;
        // 최근등록한사람부터 위에 나오도록, 그리고 create_at을 특정 포맷으로 설정. AS는 생략되어도 됨.
        $stmt = $this->conn->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute($params);
        return $stmt->fetchAll(); // 전부 가져오기, fetch는 한개만

    }

    // 글 보기
    public function view($idx)
    {
        $sql = "SELECT idx,id,subject,content,hit,create_at,file_type,likes,likers FROM free_board WHERE idx=:idx";
        $stmt = $this->conn->prepare($sql);
        $params = [':idx' => $idx];
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    // 글 조회수 +1
    public function hitInc($idx)
    {
        $sql = "UPDATE free_board SET hit=hit+1 WHERE idx=:idx";
        $stmt = $this->conn->prepare($sql);
        $params = [':idx' => $idx];
        $stmt->execute($params);
    }

    public function download($idx)
    {
        $sql = "SELECT id, file, file_type FROM free_board WHERE idx=:idx";
        $stmt = $this->conn->prepare($sql);
        $params = [':idx' => $idx];
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute($params);
        $result = $stmt->fetch();
        header("Content-type: " . $result['file_type']);
        echo $result['file'];
    }


    // 글 주인 찾기
    public function find_writer($idx)
    {
        $sql = "SELECT id FROM free_board WHERE idx=:idx";
        $stmt = $this->conn->prepare($sql);
        $params = [':idx' => $idx];
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    // 글 삭제
    public function delete($idx)
    {
        $sql = "DELETE FROM free_board WHERE idx=:idx;";
        $stmt = $this->conn->prepare($sql);
        $params = [':idx' => $idx];
        return $stmt->execute($params);
    }

    // 글 수정
    public function edit($arr)
    {
        if (isset($arr['file'])) {
            $sql = "UPDATE free_board SET subject=:subject, content=:content,file=:file, file_type=:file_type WHERE idx=:idx";
        } else {
            $sql = "UPDATE free_board SET subject=:subject, content=:content WHERE idx=:idx";

        }
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":idx", $arr['idx']);
        $stmt->bindParam(":subject", $arr['subject']);
        $stmt->bindParam(":content", $arr['content']);
        if (isset($arr['file'])) {
            $stmt->bindParam(":file", $arr['file']);
            $stmt->bindParam(":file_type", $arr['file_type']);
        }
        $stmt->execute();
    }

    // 글 좋아요
    public function like($idx, $user_id)
    {
        $sql = "SELECT likers FROM free_board WHERE idx=:idx";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":idx", $idx);
        $stmt->execute();
        $content = $stmt->fetch();

        $likers = $content['likers'];
        if ($likers != NULL) {
            $data = json_decode($likers, true); //json 배열을 php배열
            if (in_array($user_id, $data)) {
                $i = array_search($user_id, $data);
                unset($data[$i]);
                $data = array_values($data);
                $data = json_encode($data);
                $like_up = "UPDATE free_board SET likers = '{$data}', likes = likes - 1 WHERE idx=:idx";
                $stmtl = $this->conn->prepare($like_up);
                $stmtl->bindParam('idx', $idx);
                $stmtl->execute();

            } else {
                $i = count($data);
                $data[$i] = $user_id;
                $data = array_values($data);
                $data = json_encode($data);
                $like_up = "UPDATE free_board SET likers = '{$data}', likes = likes + 1 WHERE idx=:idx";
                $stmtl = $this->conn->prepare($like_up);
                $stmtl->bindParam(':idx', $idx);
                $stmtl->execute();

            }
        } else if ($likers === NULL) {
            $data = [$user_id];
            $data = json_encode($data);
            var_dump($data);
            $like_up = "UPDATE free_board SET likers=:likers, likes = likes + 1 WHERE idx=:idx";
            $stmtl = $this->conn->prepare($like_up);
            $stmtl->bindParam(':likers', $data);
            $stmtl->bindParam(':idx', $idx);
            $stmtl->execute();
        }
    }
}