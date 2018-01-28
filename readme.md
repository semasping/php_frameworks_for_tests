# Another one Benchmark of php frameworks.

In my opinion minimal functional can't show real behavior of the framework. I have decided to test php frameworks by middle complexity application. This app will be represented as "blogs platform". It consist of data about authors, theirs posts by categories and types. Such app can be realized in any framework "from a box".

Pages for testing:

* /authors - lists of authors with posts counts.
* /posts - all posts with information about types, authors and categories.
* /categories - list of categories with counts of posts in every one.
* /index - simple "hello world" for comparison.

Quantity of notes about 1000. Authors and categories - 50-100pc.

It must be quite simple app, but at the same time (imho) it is capable to show dependencies between operations with data and page generation time and consumable memory

Will page generation time be equal or comparable? What surprises can we get? I am sure, throughput will be stuck in mysql bottleneck???. But the tendency will be obvious.

## Some information about my server for tests
Centos 7.2 + vestacp + apache2.4 + php 7.1.10 + 10.2.8-MariaDB
2 X86 64bit Cores 2GB memory (https://www.scaleway.com/ Virtual SSD Cloud Servers / Starter )


### Frameworks for test
Ready for test:
* Phalcon 3.2 + Cache
* Laravel 5.4 + Cache + EagerLoading

#### Roadmap
* Implementing a test application and running tests on Symfony
* Implementing a test application and running tests on Yii
* Try to use Cache for all frameworks
* Connection with https://blackfire.io/
* Deal with the Docker and wrap it all up in it. To be able to quickly deploy to a more powerful server for comparison.

### Some tests result 
* https://steemit.com/programming/@semasping/benchmarking-php-frameworks-part-3-phalcon
* https://steemit.com/programming/@semasping/benchmark-php-frameworks-part-5-laravel
