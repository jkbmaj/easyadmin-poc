# Requirements
- PHP 8.2 or newer with ctype and iconv extensions enabled
- docker
- docker compose
- unused ports: 8003 and 13308

# How to execute
```shell
git clone https://github.com/jkbmaj/easy-admin-poc
cd easy-admin-poc
make dev
```

# Credentials
```
login: admin
password: admin
```

# Know how

## Commits without github workflows execution
- Add a new commit with one of the following messages in the body:
  - `[skip ci]`
  - `[ci skip]`
  - `[no ci]`
  - `[skip actions]`
  - `[actions skip]`