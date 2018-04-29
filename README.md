Website benchmark challenge for Xsolve
======

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jacekll/x-challenge/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jacekll/x-challenge/?branch=master)

# Installation

Be ready to provide configuration parameters, like SMSApi credentials.

Run `composer install` shell command in project main directory.

# Usage

Run `bin/console app:benchmark <main URL> <other URL1> <other URL2> <other URL3>...`
in project main directory.

By default the report contains two columns (Page load time and page load time for a second visit) to demonstrate 
the ability to include many data columns in the report. See *Adding additional data to the report* section for details

Each data column in a benchmark result is a sub-benchmark result.

# Testing

Run `phpunit` in project's main directory to run unit tests.


# Configuration

See comments in `app/config/services.yml` starting from `benchmark` service for details.

Additionally see `app/config/parameters.yml.dist` for configuration parameters.

Customize the text sent by SMS and email by editing `app/Resources/views/report/sms.txt.twig` and `email.txt.twig` templates.

# Advanced customization and Architecture

## Processor

The `AppBundle\Benchmark\Processor` is the heart of each sub-benchmark. 

It coordinates processors (objects providing the data) with reporters 
(objects reponsible for the output(s) of this data) for flexibility.

This way you can register reporting channels (SMS, email etc.) individually 
for each sub-benchmark)

## Provider

The `AppBundle\Benchmark\Provider` runs a single sub-benchmark on all 
provided websites (with the help of `AppBunle\Benchmark\WebsiteResultProvider`) and retuns an `AppBundle\Dto\TestResult` instance containing the sub-benchmark results.


## WebsiteResultProvider

Implement `AppBundle\Benchmark\WebsiteResultProvider` for an implementation of a new kind of test 
(like page size, number of assets? etc.). This class is responsible for testing a single website.

## Reporters

Reporters implement `AppBundle\Benchmark\Reporter` interface.

Reporters are responsible for the output of benchmark results.

See sample reporter definitions: `email_reporter`, `sms_reporter`, `console_reporter`
in `services.yml`

1. Implement `AppBundle\Benchmark\Reporter` to create a custom reporter
2. Register the reporter as a service
3. Register the reporter to the command with an `addReporter` call to a processor service (for example to `benchmark_processor_timer` in services.yml`)

A single reporter instance can be reused for many sub-benchmarks.

### Table reporter

`Reporter\Table` gathers data from all sub-benchmarks and outputs it as a table. 
It is configured to log both to `log.txt` file and user console.


### Conditional reporters

To have some reporters (sms, email etc.) only run conditionally, just wrap any reporter service 
in a `AppBundle\Benchmark\Reporter\ConditionalDecorator` reporter decorator, together with a condition. 

See `conditional_email_reporter` and `email_reporter` 
in `services.yml` for an example.

A conditional reporter takes:
- two required arguments: 
  - the condition (any implementation of `AppBundle\Benchmark\ReportingCondition` interface - see sample `AppBundle\Benchmark\ReportingCondition\RelativelyGreaterThan`)
  - the actual reporter service (which is invoked when only when the condition is met) 
- an optional third argument: an `AppBundle\Benchmark\ConditionVerifier` implementation; if none provided `AtLeastOneCompetitorSatisfies` will be used as a default 

### Writing custom conditions

Some reports may need customized logic for checking the conditional output for some reporters (like SMS). 

Achieve this in 2 steps:

#### 1. Implement `ReportingCondition` interface

See sample `RelativelyGreater` class.

By default, the condition is met when _at least one_ competition website satisfies it.
To change this logic, for example when you need to report something when _at least three_ 
competition websites satisfy some condition (or _all of them_), implement 
a `ConditionVerifier` interface.

#### 2. Register the condition with a conditional reporter in `services.yml`

## Adding new kinds of data to the report

1. Implement your own `WebsiteResultProvider` implementation (specify unit of measure of your test for the report - like _milliseconds_ or _bytes_)
2. Configure a `Provider` instance with your `WebsiteResultProvider` implementation
3. Configure a new benchmark processor in `services.yml`
(a `AppBundle\Benchmark\Processor` instance) - see `benchmark_provider_timer` in `services.yml` for an example
   - Register `Reporter` instances with the `Processor` to configure reporting for the new kind of data individually
4. Register the provider with `benchmark` service (with an `addProcessor` call) (see `services.yml`)
5. Enjoy :)
