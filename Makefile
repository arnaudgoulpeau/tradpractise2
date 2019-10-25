.DEFAULT_GOAL := help
help:
	@grep -E '(^[1-9a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.PHONY: help

##
## Project tools
## -------------
##

run: ## run docker containers
	docker-compose up -d

down: ## down docker containers
	docker-compose down


build: ## build images with --no-cache --force-rm --pull
	docker-compose build --no-cache --force-rm --pull

lightbuild: ## build images without
	docker-compose build

restart: down run ## restart all containers

logs: ## follow docker containers logs (run it in a separate terminal)
	docker-compose logs -f

sfcc: run ## clear symfony cache
	docker exec -it musicpractisedev  ./bin/console cache:clear $(target)

sfvendors: run ## updates vendors
	docker exec -it musicpractisedev composer install

sfroutes: run ## list symfony routes : usage : make sfroutes or make sfroutes grep="xxx"
	docker exec -it musicpractisedev ./bin/console debug:router | grep "$(grep)"

migration-diff-file: run ## create migration diff file
	docker exec -it musicpractisedev ./bin/console doctrine:migrations:diff-file

phpbash: run ## run a command on php container (usage: make phpbash command="xxx")
	docker exec -it musicpractisedev $(command)

encore: run ## encore
	docker exec -it musicpractisedev yarn encore dev

encorewatch: run ## encore watch
	docker exec -it musicpractisedev yarn encore dev --watch

encoreprod: run ## encore prod
	docker exec -it musicpractisedev yarn encore production