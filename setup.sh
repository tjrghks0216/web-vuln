#!/bin/bash

# 현재 스크립트가 있는 폴더의 절대 경로를 가져옴 (어디서 실행하든 꼬이지 않게 함)
BASE_DIR="$(cd "$(dirname "$0")" && pwd)"

echo "▶️ 프로젝트 경로 인식: $BASE_DIR"

# 1. 기존 컨테이너 강제 삭제
echo "🧹 기존 studentWeb 컨테이너를 정리합니다..."
sudo docker rm -f studentWeb 2>/dev/null

# 2. 도커 컨테이너 실행 (절대 경로 $BASE_DIR 사용)
echo "🚀 새로운 도커 컨테이너를 실행합니다..."
sudo docker run -d -p "1018:80" --name studentWeb \
    -v "$BASE_DIR/webApp:/app" \
    mattrayner/lamp:0.8.0-2004-php7

# 3. MySQL 서버가 완전히 부팅될 때까지 스마트하게 대기
echo "⏳ MySQL 서버 부팅 대기 중 (최대 60초)..."
for i in {1..30}; do
    # mysqladmin ping 명령어로 DB가 응답하는지 체크
    if sudo docker exec studentWeb mysqladmin ping -u root --silent; then
        echo -e "\n✅ MySQL 부팅 완료!"
        break
    fi
    echo -n "."
    sleep 2
done

# 4. 데이터베이스 및 admin 계정 자동 셋업
echo "🛠️ 데이터베이스와 admin 계정을 설정합니다..."
sudo docker exec -i studentWeb mysql -u root -e "
DROP DATABASE IF EXISTS inthewhiteshadow;
CREATE DATABASE inthewhiteshadow;
DROP USER IF EXISTS 'admin'@'localhost';
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'tjrghks0216';
GRANT ALL PRIVILEGES ON inthewhiteshadow.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;
"

# 5. SQL 파일 임포트 (database 폴더 안에 있는 파일 참조)
SQL_FILE="$BASE_DIR/database/localhost.sql"

if [ -f "$SQL_FILE" ]; then
    echo "📦 $SQL_FILE 데이터를 밀어 넣습니다..."
    sudo docker exec -i studentWeb mysql -u root inthewhiteshadow < "$SQL_FILE"
    echo "================================================="
    echo "✅ 모든 셋업이 완료되었습니다!"
    echo "✅ 웹사이트 접속: http://localhost:1018"
    echo "================================================="
else
    echo "❌ 에러: database/localhost.sql 파일을 찾을 수 없습니다!"
fi
