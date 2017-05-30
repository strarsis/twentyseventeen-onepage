# Live demo

## Usage

- Clone this repository. `git clone https://github.com/strarsis/twentyseventeen-onepage`
- Go into this directory. `cd twentyseventeen-onepage/live-demo`
- [Docker](https://docs.docker.com/engine/installation/) + [Docker Compose](https://docs.docker.com/compose/install/) have to be installed.
- Start containers using `docker-compose up -d`, this will start a MariaDB database container and a WordPress container with this theme mounted as folder into WordPress theme directory.
- Run `./setup.sh`, passing host + port of development machine to it - to which you will point your browser on later, e.g. `./setup.sh mybox 8080`.
- When setup script has finished, load the site in your browser using the host + port previously specified, e.g. `http://mybox:8080`.
