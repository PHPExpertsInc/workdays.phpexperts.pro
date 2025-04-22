# workdays.phpexperts.pro

[![Maintainability]()]()
[![Test Coverage]()]()

workdays.phpexperts.pro is a PHP Experts, Inc., public REST API service.

It will tell you the following:
* Is today a holiday in a country?
* When is the next holiday in a country?
* Generate an array of workdays in a given date range.


Minimum supported PHP version: 8.2.

### Core Dependencies

* [phpexperts/workday-planner](https://github.com/PHPExpertsInc/WorkdayPlanner)
* [phpexperts/mini-api-base](https://github.com/PHPExpertsInc/MiniApiBase)
* [phpexperts/mini-api-core](https://github.com/PHPExpertsInc/MiniApiCore)
* [minicli/minicli (PHP Experts' fork)](https://github.com/PHPExperts-Contribs/minicli) 
* [pecee/simple-router](https://github.com/skipperbent/simple-php-router) 
* [phpexperts/console-painter](https://github.com/PHPExpertsInc/ConsolePainter) 
* [phpexperts/laravel-env-polyfill](https://github.com/PHPExpertsInc/Laravel57-env-polyfill) 
* [phpexperts/rest-speaker](https://github.com/PHPExpertsInc/RESTSpeaker)
* [phpexperts/simple-dto](https://github.com/PHPExpertsInc/SimpleDTO) 

## Installation

Via Composer

```bash
composer create-project phpexperts/workdays.phpexperts.pro api.my.site
```

## Usage

You can instantly launch this via Docker by running `docker compose up -d`.

## Use cases

 ✔ Rapidly start up a project right.  
 ✔ Less time spent on boilerplating a git repo.  
 ✔ Conforms to the most widely-deployed PHP layout.  
 ✔ Fully compatible with the Bettergist Collective recommendation.  

## Testing

```bash
phpunit
```

## Contributors

[Theodore R. Smith](https://www.phpexperts.pro/]) <theodore@phpexperts.pro>  
GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690  
CEO: PHP Experts, Inc.

## License

Creative Commons Attribution No Derivatives v4.0 license.

Please see the [license file](LICENSE.cc-by-nd.md) for more information.
