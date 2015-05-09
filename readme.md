# Furnace

Furnace is an application to rate Rocksmith CDLCs

## Contributing

First you'll need to clone the repository locally and boot its VM:

```bash
$ git clone -b develop git@github.com:Anahkiasen/furnace.git
$ cd furnace
$ vagrant up
```

Then go inside the box, and install the dependencies:

```bash
$ composer install
$ npm install
$ bower install
```

Now compile the front-end assets:

```bash
$ gulp
```
