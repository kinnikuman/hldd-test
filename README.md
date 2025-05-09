# Readme

# Requirements

- Docker & Docker-compose

# Installation

Docker-compose is needed!

1 - Clone this repo 😀

2- From the root folder run
`docker-compose build --no-cache` and
`docker-compose up --build -d`

Three containers will be created: 1 for nginx, 1 for php (8.1 version) and another one for database (Mysql)

3- Run composer install with `docker-compose exec  php composer install` and
run doctrine migrations with `docker-compose exec  php bin/console doctrine:migrations:migrate --no-interaction`

4- Now, you can make calls to the different API endpoints:

PUT `http://localhost:3000/api/service` : endpoint to update the vendor machine items and money.

Example of json body for this request:

```
{
    "items": [{
        "name": "SODA",
        "price": 0.25,
        "count": 7
    }, {
        "name": "WATER",
        "price": 1,
        "count": 510
    }],
    "money":[{
        "coinCents":100,
        "numberOfCoins":3
    },
    {
        "coinCents":25,
        "numberOfCoins":8
    }]
}
```

POST `http://localhost:3000/api/coins/{coinInFloat}` : endpoint to insert coins. You must change the {coinInFloat} variable
with the value of your coin (0.05,0.1,0.25,1)

GET `http://localhost:3000/api/coins` : endpoint to return the inserted coins.

POST `http://localhost:3000/api/items/{itemName}/buy` : endpoint to buy an item. Returns the item and the change. Replace
the variable itemName with the value of the item to buy.

I have added a postman collection in the root of the repository (vending-machine.postman_collection.json) with all of these endpoins
with example data.

You can access into the mysql DB with the following parameters:

```
host: localhost
port: 3306
user: root
password: password
database: main
```

# Notes

- Running the migration will create the tables and will insert some default 
data (3 items: WATER,SODA,JUICE, and some money)
- Service endpoint to update vendor machine will remove all inserted user coins. This endpoint reset the status
of the vending machine because is only executed during a maintenance service.
- I created the base code of this project (symfony, docker and code like commandBus, queryBus, etc.) using
a private repo that I have in my gitHub for these purpose (symfony6-skeleton). Basically I cloned my symfony6-skeleton 
repo, removed the .git and init into a new repo, removing some unnecessary files. If you want access to this repo to 
ensure that the code is mine, please let me know to share my private repo with you.