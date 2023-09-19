SHELL := /bin/bash
.SHELLFLAGS += -e

# Common ----------------------------------------------------------------
.PHONY: purge
purge:
	rm -f .env.local.php *cache .*cache
	rm -Rf var/cache/* var/log/* vendor

.PHONY: install
install:
	symfony composer install

.PHONY: refresh
refresh: down purge install

.PHONY: down
down:
	symfony server:stop
	docker compose down

.PHONY: compose_start
compose_start:
	docker compose up -d
	until mysqladmin ping -s -h 127.0.0.1 --port=13308 -uuser --password=password > /dev/null 2>&1; do \
		sleep 1; \
	done
	symfony console doctrine:schema:drop --full-database --force
	symfony console doctrine:migration:migrate --no-interaction
	symfony console doctrine:fixtures:load --no-interaction
# EndCommon -------------------------------------------------------------


# Dev -------------------------------------------------------------------
.PHONY: dev
dev: down install compose_start
	symfony server:start --daemon --port=8003 && symfony open:local
# EndDev ----------------------------------------------------------------
