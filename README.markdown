pChart 1 for PHP 5
==========================

## Why?

pChart is a great charting library for PHP. The original library
(http://pchart.sourceforge.net/) was written in PHP4 and is no longer maintained.
It's author created a new version called pChart 2 that is available at
http://www.pChart.net

Unfortunately his licesing terms lined out at http://www.pchart.net/license
are confusing:

> If your application is not a commercial one (eg: you make no money by
> redistributing it) then the GNU GPLv3 license (General Public License)
> applies.

This is contradicting itself. The exclusion of commercial appliance is in direct
violation with the GPL and thus renders it invalid. This standard copyright
applies and the library can not be used in any Open Source program.

The author was informed about these invalid license terms in November 2011, but
hasn't changed anything.

This leaves only the old, GPL Version 2 licensed version 1 of pChart.
However, it has not been updated in a long time and it's compatibility
with PHP 5 will soon be lost because of new language features 
(namely constuctors can no longer be the class name as of PHP 5.3.3)

This project aims to update the library to modern PHP5. It will not retain
backward compatibility with the old API (though it will not be changed
unnecessarily)

## Goals

The goal of this project is:

* Update pChart to use PHP 5 object-oriented language features
* Fix bugs
* Refactor as needed
* Add proper docblocks to all functions (and there's a lot of them)
* Rename some functions (it seems the original author's native language was not english)
* Have clear a license
 
## Status

This project was started by github user aweiland at https://github.com/aweiland/pChart-php5
but all the API documentation and continuous integration server seems
to be down. Development was picked up by github users timmartin and sebix
but stopped again.

The current repository at https://github.com/splitbrain/pChart is the most
recent pickup, but I'd be happy to give development over to whoever wants to
drive this project forward.

## Todo

* unit tests are failing currently but I'm not sure that comparing md5 sums of
  action logs is the right way to test anyway
* the example files are probably the best way to really test the library for
  break/non-break state - these should be integrated into the test suite
* the example files 15 to 29 are currently broken, probably just because of
  API changes not real bugs
* the code needs more cleanup and most importantly useful doc comments to auto
  create a usable API documentation
