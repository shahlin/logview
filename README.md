<p align="center">
    <img title="logview" height="100" src="https://i.imgur.com/2Y6ToG1.png" />
</p>

# Introduction
**Logview** is an interactive CLI tool that lets you view changelogs of some of your favourite open source projects online. You get to view it in the default markdown format or in a custom designed HTML format. Logview also lets you merge multiple version changelogs into a single one and view them at once.

## Why did I make this?
I wanted to migrate a project from a way older version to the latest one available. This migration had to be manually done. To make sure I don't miss out on the important/breaking changes between each of the versions, I wanted to have a view of all the changes between version X to version Y. Instead of manually saving the changelogs one by one, I decided to make this.

_Late realization_: Many changelog files already list down previous version changes within the same changelog. But it doesn't always list **all** versions though, so I guess I can still make use of the merge functionality.

![Logview usage sample](https://media.giphy.com/media/F5hd6aHmylGqBjGUAy/giphy.gif)

# Usage

## Minimum Requirements
1. PHP 8+
2. Composer

## Running Logview
1. Clone this repository and run the commands below inside the project
2. Install all the dependencies
```
composer install
```
3. Start the interactive session and navigate your way through the terminal!
```
php logview generate
```
4. Once the changelog is generated, you can view it in the same directory. It will be stored as output._extension_ (could be `md` or `html`)

## Currently Supports
Currently, changelogs can be generated for the following services only:
1. Laravel
2. React
3. Laravel Horizon

# Contributing
There's no full fledged contributing guidelines as of now since the tool is quite small and just a hobby project.

If you wish to add new services to the generate the changelogs for, you can do so without actually having to code for it. Follow the steps below:
1. Open `config/services.php`
2. Create a new key with a unique identifier to the service
3. Give it a name, url (url to the changelog) and list of versions. Follow the same format as the others.
4. The url must contain the version number in it for it to be correctly generated. Replace the actual version number in the url with `Service::VERSION_EXPR`
5. Your service will be added!
