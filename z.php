<?php

Assert::allFile($configFiles);
Assert::allIsAOf($compilerPasses, CompilerPassInterface::class);
Assert::allIsInstanceOf($tags, Tag::class);
Assert::allNotNull
Assert::allString($directories);
Assert::allStringNotEmpty(
Assert::boolean
Assert::classExists($handler);
Assert::count($arguments, 0);
Assert::eq($analyzer->getNumberOfArguments($contructor), 0);
Assert::greaterThanEq($startingLine, 1);
Assert::implementsInterface($handler, Tag::class);
Assert::integerish($startingLine);
Assert::isCallable($callable);
Assert::isInstanceOf($nodes, DOMNodeList::class);
Assert::isInstanceOfAny(
Assert::isMap($params, 'Expected $params to have only string keys');
Assert::keyExists
Assert::maxLength($name, self::MAX_LENGTH);
Assert::minCount(
Assert::notEmpty(
Assert::notEndsWith($name, ' ');
Assert::notNull($descriptionFactory);
Assert::null($this->microTime, 'Timer can not be started again without stopping.');
Assert::nullOrIntegerish($lineCount);
Assert::nullOrNotEmpty($version);
Assert::oneOf($mutatorClass, ProfileList::ALL_MUTATORS);
Assert::range($statusCode,200,599,'Expected an HTTP status code. Got "%s"');
Assert::string($docblock);
Assert::stringNotEmpty($docblock);
Assert::subclassOf(
Assert::true($s
Assert::fileExists(
Assert::inArray(
