# vulnerable application

[![aasaam](https://flat.badgen.net/badge/aasaam/software%20development%20group/0277bd?labelColor=000000&icon=https%3A%2F%2Fcdn.jsdelivr.net%2Fgh%2Faasaam%2Finformation%2Flogo%2Faasaam.svg)](https://github.com/aasaam)

[![docker-repository-on-quay](https://flat.badgen.net/badge/quay.io/repo/cyan)](https://quay.io/repository/aasaam/vulnerable-application)

This is the simple vulnerable application for testing using [sqlmap](https://github.com/sqlmapproject/sqlmap), [XSStrike](https://github.com/s0md3v/XSStrike), [testssl.sh](https://github.com/drwetter/testssl.sh) for testing the Web server, TLS, WAF rules, protection and etc...

It's use [aasaam web-server](https://github.com/aasaam/web-server) for edge waf/reverse/proxy/ssl off loader.

## Run

```bash
git clone --depth 1 https://github.com/aasaam/vulnerable-application
cd vulnerable-application
docker-compose up -d
# wait for all databases to be ready
```

You can see app run in browser

* `http://localhost:10800` Normal application
* `http://localhost:10801` Behind aasaam web-server WAF activated
* `https://localhost:10802` Behind aasaam web-server WAF and SSL/TLS activated

## SQL Injection check

```bash
git clone --depth 1 https://github.com/sqlmapproject/sqlmap.git tmp/sqlmap-dev
cd tmp/sqlmap-dev
# remove old tests result
rm ~/.local/share/sqlmap -rf
# no waf
./sqlmap.py -u 'http://localhost:10800/show.php?id=1&type=bXlzcWw=&title=DevOps+is+important'
# with waf
./sqlmap.py -u 'http://localhost:10801/show.php?id=1&type=bXlzcWw=&title=DevOps+is+important'
```

## XSS Check

```bash
git clone --depth 1 https://github.com/s0md3v/XSStrike.git tmp/XSStrike
cd tmp/XSStrike
# no waf
python3 xsstrike.py --fuzzer --blind -u 'http://localhost:10800/show.php?id=1&type=bXlzcWw=&title=DevOps+is+important'
# with waf
python3 xsstrike.py --fuzzer --blind -u 'http://localhost:10801/show.php?id=1&type=bXlzcWw=&title=DevOps+is+important'
```

## Test SSL/TLS

```bash
git clone --depth 1 https://github.com/drwetter/testssl.sh tmp/testssl.sh
cp addon/ssl/ca.pem tmp/testssl.sh/ca.pem
cd tmp/testssl.sh
./testssl.sh --add-ca ca.pem 'https://localhost:10802'
```

## Benchmark

```bash
mkdir -p tmp/cassowary
cp addon/ssl/ca.pem tmp/cassowary/ca.pem
cd tmp/cassowary
wget -O cassowary.tgz https://github.com/rogerwelin/cassowary/releases/download/v0.11.0/cassowary_0.11.0_Linux_x86_64.tar.gz
tar -xf cassowary.tgz
./cassowary run --ca ca.pem -c 100 -n 10000 -u 'https://localhost:10802/benchmark'
```
