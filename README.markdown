pChart PHP 5 Compatibility
==========================

pChart is a great charting library for PHP. 
However, it has not been updated in a long time and it's compatibility
with PHP 5 will soon be lost because of new language features 
(namely constuctors can no longer be the class name as of PHP 5.3.3)

The v2 branch will not retain backward compatibility with the old API
(though it will not be changed unnecessarily)

## Goals

The goal of this project is:

* Update pChart to use PHP 5 object-oriented language features
* Fix bugs
* Refactor as needed
* Add proper docblocks to all functions (and there's a lot of them)
* Rename some functions (it seems the original author's native language was not english)
 
## Status

The main body of the code now has over 75% unit test coverage, and
all the examples appear to be working. If you're starting a new
project, it's probably reasonable to use this distribution in
preference to the Sourceforge distribution, since any bugs in this
distribution should hopefully be fixed on a reasonable timescale.

## Code cleanup

The code has some questionable style issues, most noticeably
inconsistent use of camel casing for method names. This isn't a
particularly big deal in itself, since method names are
case-insensitive, but we aim to clean it up as part of this project.

## Branches

There are several branches of the code:

* **master** is the current development trunk, which is a substantial
  rewrite in a more modern, Object-Oriented style. The API is still
  under heavy development and is not yet stable, though there should
  be a release branch of this before long.
* **v2** is the branch that originally housed the API rewrite when it
  was too unstable to be used, but is now probably obsolete
* **v1** retains full (or almost full) backward compatibility with the	
  API of the original pChart, but has been updated for PHP 5 OO and
  cleaned up a little
* **gdline** is an experimental optimisation based on the **v1** branch 
  that uses the native GD line drawing rather than drawing pixel-by-pixel.
  It is substantially faster (400% in some cases) but doesn't have
  antialiasing or drop-shadows working. Eventually I intend
  to incorporate these improvements in as optional speedups to the
  main branch, but for now if you need speed and don't care too much
  about prettiness, this is a viable option.
 
## Future development

I've been pondering switching to Cairo over GD as the rendering
engine, since the support for antialiasing doesn't seem to be reliably
present on PHP. This probably won't happen until after a release of
the v2 API branch has gone out, at the very least.