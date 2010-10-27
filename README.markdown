pChart PHP 5 Compatibility
==========================

pChart is a great charting library for PHP. 
However, it has not been updated in a long time and it's compatibility
with PHP 5 will soon be lost because of new language features 
(namely constuctors can no longer be the class name as of PHP 5.3.3)

## Goals

The goal of this project is:

* Update pChart to use PHP 5 object-oriented language features
* Fix bugs
* Refactor as needed
* Add proper docblocks to all functions (and there's a lot of them)
* Attempt to maintain compatibility with existing scripts (i.e. do not rename/remove any public functions)
* Rename some functions but keep references to existing (it seems the original author's native language was not english)
 
## Status

The main body of the code now has around 66% unit test coverage, and
all the examples appear to be working. If you're starting a new
project, it's probably reasonable to use this distribution in
preference to the Sourceforge distribution, since any bugs in this
distribution should hopefully be fixed on a reasonable timescale.

## Code cleanup

The code has some questionable style issues, most noticeably
inconsistent use of camel casing for method names. This isn't a
particularly big deal in itself, since method names are
case-insensitive, but we aim to clean it up as part of this project.

## Development versions

There are currently two development branches, both of which are usable
but may not be relied upon not to change in the future:

* **v2** is an attempt to rewrite the API to a more modern,
  Object-Oriented style. This API is currently still unstable, though
  the code is unit-tested and should be pretty functional, so if
  you're happy fixing your own bugs or updating the API as it changes,
  this could be usable. I intend soon to do a release branch that will
  be kept up to date with bug fixes
* **gdline** is an experimental optimisation that uses the native GD
  line drawing rather than drawing pixel-by-pixel. It is substantially
  faster (400% in some cases) but doesn't have antialiasing or
  drop-shadows working. It's based off the v1 API. Eventually I intend
  to incorporate these improvements in as optional speedups to the
  main branch, but for now if you need speed and don't care too much
  about prettiness, this is a viable option.
 
## Future development

I've been pondering switching to Cairo over GD as the rendering
engine, since the support for antialiasing doesn't seem to be reliably
present on PHP. This probably won't happen until after a release of
the v2 API branch has gone out, at the very least.