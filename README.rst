PHP Namespace Importer
======================

A little hack to require in PHP files based upon their namespace. It was built to make it easier to consume functional "packages" in development.

It will only attempt to load namespaces referenced before the call to ``Treffynnon\Loader\Load()`` everything after it is assumed to be manually loaded or handled by a class autoloader. In addition it will only consider the first 8000 characters of a file for importation.

**Warning:** This hack uses the PHP Tokenizer to double parse the file so it is inefficient to use.

Let's see some code
-------------------

.. code-block:: php

    <?php
    // these `use` statements will be loaded using the namespace importer
    use Treffynnon\Primitives\Sort as TS;
    use Treffynnon\Primitives\Pick as TP;

    require_once 'bootstrap.php';
    Treffynnon\Loader\Load(__FILE__);

    // these ones will not
    use Functional as F,
        React\Curry;                  

It is now possible to use the Treffynnon\\Primitives like so:

.. code-block:: php

    <?php
    $result = TS\sort($service_records, function($a, $b) {
        return ($a > $b);
    });
