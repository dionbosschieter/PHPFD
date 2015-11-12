# PHPFD

PHP Filesystem function call detector

Little script I wrote to check if there are any php files
using the PHP's filesystem functions instead of a custom Storage class.

## Usage:
`$ ./phpfd.phar`
```
Usage:
  command [options] [arguments]

Options:
  -h, --help            Display this help message
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  find  Searches php files in a given path (current path by default)
  help  Displays help for a command
  list  Lists commands
```
