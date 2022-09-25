<?php

Assert::isInstanceOf($nodes, DOMNodeList::class);
Assert::isInstanceOfAny();
Assert::allIsAOf($compilerPasses, CompilerPassInterface::class);
Assert::allIsInstanceOf($tags, Tag::class);
Assert::oneOf($mutatorClass, ProfileList::ALL_MUTATORS);
Assert::implementsInterface($handler, Tag::class);
Assert::subclassOf();

Assert::allFile($configFiles);
Assert::allNotNull();
Assert::allString($directories);
Assert::allStringNotEmpty();

Assert::notEmpty();
Assert::notNull($descriptionFactory);
Assert::null($this->microTime, 'Timer can not be started again without stopping.');
Assert::nullOrIntegerish($lineCount);
Assert::nullOrNotEmpty($version);

Assert::inArray();
Assert::boolean();
Assert::classExists($handler);
Assert::eq($analyzer->getNumberOfArguments($contructor), 0);
Assert::greaterThanEq($startingLine, 1);
Assert::maxLength($name, self::MAX_LENGTH);
Assert::range($statusCode, 200, 599, 'Expected an HTTP status code. Got "%s"');

Assert::integerish($startingLine);
Assert::isCallable($callable);
Assert::notEndsWith($name, ' ');
Assert::string($docblock);
Assert::stringNotEmpty($docblock);
Assert::true($s);
Assert::fileExists();
