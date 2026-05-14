# 🛡️ AI 기반 웹 취약점 진단 실습 환경 (Web Vulnerability Lab)

본 프로젝트는 파이썬과 AI를 활용하여 웹 서버의 **HTTP 응답 헤더 설정 미흡 및 취약점**을 진단하기 위한 실습용 타겟 환경(Target Server)입니다.

다양한 OS 환경(Windows, Mac)에서의 충돌 및 버그(특히 Vagrant/VirtualBox의 공유 폴더 DB 락킹 이슈)를 방지하기 위해, **VMware 기반의 Ubuntu 가상머신**에서 도커(Docker)를 이용해 구동하는 것을 표준으로 합니다.

---

## 🚀 1. 사전 준비 (VMware & SSH 세팅)

VMware 콘솔 화면에서는 복사/붙여넣기가 원활하지 않으므로, 윈도우/맥 터미널에서 SSH로 원격 접속하여 세팅하는 것을 강력히 권장합니다.

**1. VMware의 Ubuntu에서 터미널을 열고 IP 주소 확인**
```bash
ip a
# ens33 또는 eth0 항목의 192.168.X.X 확인
```

**2. Ubuntu에 SSH 서버 설치 (안 되어 있는 경우)**
```bash
sudo apt update
sudo apt install openssh-server -y
```

**3. 로컬 PC(Windows/Mac) 터미널에서 SSH 접속**
```bash
# 본인의 리눅스 계정명과 확인한 IP를 입력하여 접속
ssh gildong@192.168.10.100
```

---

## 🐳 2. Docker 완벽 설치 가이드

SSH로 접속한 터미널에서 아래 명령어들을 순서대로 복사/붙여넣기 하여 Docker를 설치합니다.

**1. 충돌 방지를 위한 기존 패키지 삭제**
```bash
for pkg in docker.io docker-doc docker-compose docker-compose-v2 podman-docker containerd runc; do sudo apt-get remove -y $pkg; done
```

**2. 필수 패키지 설치 및 GPG 키 등록**
```bash
sudo apt-get update
sudo apt-get install -y ca-certificates curl
sudo install -m 0755 -d /etc/apt/keyrings
sudo curl -fsSL [https://download.docker.com/linux/ubuntu/gpg](https://download.docker.com/linux/ubuntu/gpg) -o /etc/apt/keyrings/docker.asc
sudo chmod a+r /etc/apt/keyrings/docker.asc
```

**3. Docker 저장소 추가 및 엔진 설치**
```bash
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] [https://download.docker.com/linux/ubuntu](https://download.docker.com/linux/ubuntu) \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

sudo apt-get update
sudo apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

---

## ⚙️ 3. 프로젝트 가져오기 및 자동 셋업

도커 설치가 완료되었다면, Git 클론을 받고 자동화 스크립트 단 한 줄로 환경 구성을 끝냅니다.

**1. 프로젝트 다운로드 (Clone)**
```bash
git clone https://github.com/tjrghks0216/web-vuln.git
cd web-vuln
```

**2. 자동화 스크립트 실행**
웹 앱 소스코드 마운트, DB 초기화, admin 계정 설정 및 더미 데이터(SQL) 주입이 모두 자동으로 진행됩니다.
```bash
chmod +x setup.sh
./setup.sh
```

---

## ✅ 4. 접속 확인

모든 셋업이 완료되었다면, PC(Windows/Mac)의 웹 브라우저를 열고 아래 주소로 접속합니다.

접속 URL: http://[VMware_Ubuntu_IP주소]:1018

---

## 💡 (참고) 환경 초기화가 필요할 때

설정 파일을 과도하게 만졌거나 데이터베이스가 꼬였을 경우, 언제든지 프로젝트 폴더에서 ./setup.sh를 다시 실행하면 15초 만에 모든 환경이 깨끗한 초기 상태로 복구됩니다.
