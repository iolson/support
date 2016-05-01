# Continuous Integration Generators

When starting a new project, getting the configurations setup for CI vendors is usually a copy/paste from a previous project. I decided to include these in my support package, so I could quickly build out CI configurations without having to go back to another project and copy/paste.

## Cricle CI

To generate a default Circle CI configuration, simply execute the `support:ci:circle` Artisan command.

By default this has configurations for:

- PHP 7.0.4

```bash
$ php artisan support:ci:circle
```

More information regarding Circle CI configuration setup can be found [here](https://circleci.com/docs/language-php/).

## GitLab CI

To generate a default GitLab CI configuration, simply execute the `support:ci:gitlab` Artisan command. This will run the tests in docker containers. You will need to uncomment the tests that you want to have ran.

By default this has configurations for:

- PHP 5.6 Apache
- PHP 5.6 FPM
- PHP 7 Apache
- PHP 7 FPM

```bash
$ php artisan support:ci:gitlab
```

More information regarding GitLab CI configuration setup can be found [here](http://doc.gitlab.com/ce/ci/examples/php.html).

## Travis CI

To generate a default Travis CI configuration, simply execute the `support:ci:travis` Artisan command.

By default this has configurations for:

- PHP 5.6
- PHP 7

```bash
$ php artisan support:ci:travis
```

More information regarding Travis CI configuration setup can be found [here](https://docs.travis-ci.com/user/languages/php).