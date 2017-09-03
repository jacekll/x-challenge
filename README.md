xsolve
======

Usage:

Run `bin/console app:benchmark <main URL> <other URL1> <other URL2> <other URL3>...`
in project main directory.

Configuration
-------------
See `benchmark` service in `app/config/services.yml`

Reporters
---------
See sample reporter definitions: `email_reporter`, `sms_reporter`, `console_reporter`
in `services.yml`

1. Implement `AppBundle\Benchmark\Reporter` to create a custom reporter
2. Register the reporter as a service
3. Register the reporter to the command with an `addReporter` call to `benchmark` service (see `services.yml`)

Conditional reporters
---------------------

Just wrap any reporter service in a `AppBundle\Benchmark\Reporter\Conditional` 
reporter, together with a condition.

Writing custom conditions
-------------------------

Implement `ReportingCondtition` interface
See sample `RelativelyGreater` class.

By default, the condition is met when _at least one_ competition website satisfies it.
To change this logic, for example when you need to report something when _at least three_ 
competition websites satisfy some condition (or _all of them_), implement 
a `ConditionVerifier` interface.
