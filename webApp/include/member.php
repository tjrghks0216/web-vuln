<?php

class Member
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // 회원가입 시 주소 검색
    public function address_search($input)
    {
        $arr = explode(" ", $input);

        if (isset($arr[1])) {
            $sql = "SELECT * FROM ZIPCODE WHERE DORO LIKE :arr0 AND BUILD_NO1 LIKE :arr1";
            $stmt = $this->conn->prepare($sql);
            $arr0 = '%' . $arr[0] . '%';
            $arr1 = '%' . $arr[1] . '%';
            $stmt->bindParam(':arr0', $arr0);
            $stmt->bindParam(':arr1', $arr1);
        } else {
            $sql = "SELECT * FROM ZIPCODE WHERE DORO LIKE :arr0 ORDER BY DORO ASC, BUILD_NO1";
            $stmt = $this->conn->prepare($sql);
            $arr0 = '%' . $arr[0] . '%';
            $stmt->bindParam(':arr0', $arr0);
        }
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 아이디 중복 체크
    public function id_exist($id)
    {
        $sql = "SELECT * FROM member WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount() ? true : false;
    }

    // 이메일 형식 체크
    public function email_format_check($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    // 이메일 중복 체크
    public function email_exist($email)
    {
        $sql = "SELECT * FROM member WHERE email=:email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() ? true : false;
    }

    // 회원정보 입력
    public function input($marr)
    {
        $new_hash_password = password_hash($marr['password'], PASSWORD_DEFAULT); // 비밀번호 단방향 암호화

        $sql = "INSERT INTO member (id, password, email, addr1, addr2) VALUES (:id, :password, :email, :addr1, :addr2)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $marr['id']);
        $stmt->bindParam(":email", $marr['email']);
        $stmt->bindParam(":password", $new_hash_password);
        $stmt->bindParam(":addr1", $marr['addr1']);
        $stmt->bindParam(":addr2", $marr['addr2']);
        $stmt->execute();
    }

    // 로그인
    public function login($id, $pw)
    {
        $sql = "SELECT * FROM member WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if ($stmt->rowCount()) {
            $row = $stmt->fetch();
            if (password_verify($pw, $row['password'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // 회원정보 불러오기
    public function user_info($id)
    {
        $sql = "SELECT id,email,addr1,addr2 FROM member WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        if ($stmt->rowCount()) {
            $row = $stmt->fetch();
            return $row;
        } else {
            return false;
        }
    }

    // 회원 정보 수정
    public function edit($marr)
    {
        $auth_sql = "SELECT * FROM member WHERE id=:id";
        $stmt_auth = $this->conn->prepare($auth_sql);
        $stmt_auth->bindParam(":id", $marr['id']);
        $stmt_auth->execute();

        $row = $stmt_auth->fetch();
        if (!password_verify($marr['password_before'], $row['password'])) {
            return false;
        }


        $sql = 'UPDATE member SET email=:email, addr1=:addr1, addr2=:addr2';
        $params = [
            ':email' => $marr['email'],
            ':addr1' => $marr['addr1'],
            ':addr2' => $marr['addr2'],
        ];

        // 비밀번호를 변경했다면
        if ($marr['password'] != '') {
            $new_hash_password = password_hash($marr['password'], PASSWORD_DEFAULT); // 비밀번호 단방향 암호화
            $params[':password'] = $new_hash_password;
            $sql .= ', password=:password';
        }

        $params[':id'] = $marr['id'];
        $sql .= ' WHERE id=:id';

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params); // 배열로 bind하고 바로 실행
    }

}