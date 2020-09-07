# vulnerable application

[![aasaam](https://flat.badgen.net/badge/aasaam/software%20development%20group/0277bd?labelColor=000000&icon=https%3A%2F%2Fcdn.jsdelivr.net%2Fgh%2Faasaam%2Finformation%2Flogo%2Faasaam.svg)](https://github.com/aasaam)

This is the simple vulnerable application for testing using [sqlmap](https://github.com/sqlmapproject/sqlmap) and [XSStrike](https://github.com/s0md3v/XSStrike) for testing the WAF rules and protection mechanism.

## SQL Injection check

```bash
git clone --depth 1 https://github.com/sqlmapproject/sqlmap.git tmp/sqlmap-dev
cd tmp/sqlmap-dev
./sqlmap.py -u 'http://localhost:21900/show.php?id=1&type=mysql&title=Lorem+ipsum+dolor+sit+amet%2C+consectetur+adipiscing+elit.'
```

## XSS Check

```bash
git clone --depth 1 https://github.com/s0md3v/XSStrike.git tmp/XSStrike
cd tmp/XSStrike
python3 xsstrike.py -u 'http://localhost:21900/show.php?id=3&type=mysql&title=Aliquam+eget+leo+faucibus%2C+accumsan+nunc+id%2C+interdum+nisl.'
```

## Notice

Use adminer to create database for MSSQL.

```txt
http://localhost:21901
```
