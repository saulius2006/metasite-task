# Starting a new project
copy the files from the directory then run these commands from your CLI.

- docker-compuse build
- docker-compose up

# Switching project
With docker you can easily switch between projects since starting and stopping containers is no big deal.

First, make sure you kill your running (if any) container with **docker-compose kill**

Then cd into the directory of your other project and simly run **docker-compose up**

# Cheat-sheet
A few commands I use fairly often

## SSH into a container
- docker exec -it <container_id> bash

Or for windows try:

- winpty docker exec -it <container_id> bash

You can find you container id with **docker ps** 

## Run drush commands
cd into project root directory

docker-compose run drush <drush commands>
