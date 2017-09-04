Website benchmark challenge for Xsolve
======

# Installation

Be ready to provide configuration parameters, like SMSApi credentials.

Run `composer install` shell command in project main directory.

# Usage

Run `bin/console app:benchmark <main URL> <other URL1> <other URL2> <other URL3>...`
in project main directory.

# Testing

Run `phpunit` in project's main directory to run unit tests.


# Configuration

See comments in `app/config/services.yml` starting from `benchmark` service

## Reporters

See sample reporter definitions: `email_reporter`, `sms_reporter`, `console_reporter`
in `services.yml`

1. Implement `AppBundle\Benchmark\Reporter` to create a custom reporter
2. Register the reporter as a service
3. Register the reporter to the command with an `addReporter` call to a processor service (for example to `benchmark_processor_timer` in services.yml`)

### Conditional reporters

Just wrap any reporter service in a `AppBundle\Benchmark\Reporter\Conditional` 
reporter, together with a condition. 

See `conditional_email_reporter` and `email_reporter` 
in `services.yml` for an example.

A conditional reporter takes:
- two required arguments: 
  - the condition (any implementation of `AppBundle\Benchmark\ReportingCondition` interface - see sample `AppBundle\Benchmark\ReportingCondition\RelativelyGreaterThan`)
  - the actual reporter service (which is invoked when only when the condition is met) 
- an optional third argument: an `AppBundle\Benchmark\ConditionVerifier` implementation; if none provided `AtLeastOneCompetitorSatisfies` will be used as a default 

### Writing custom conditions


#### 1. Implement `ReportingCondition` interface

See sample `RelativelyGreater` class.

By default, the condition is met when _at least one_ competition website satisfies it.
To change this logic, for example when you need to report something when _at least three_ 
competition websites satisfy some condition (or _all of them_), implement 
a `ConditionVerifier` interface.

#### 2. Register the condition with a conditional reporter in `services.yml`

## Adding additional data to the report

1. Configure a benchmark processor 
(a `AppBundle\Benchmark\Processor` implementation) - see `benchmark_provider_timer` in `services.yml` for an example
2. Register the benchmark provider to the command with an `addProcessor` call to `benchmark` service (see `services.yml`)