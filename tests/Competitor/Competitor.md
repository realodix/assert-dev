
Beberlei: 25/91 (27.47%) <br>
Webmozarts: 35/95 (36.84%)

---

## Beberlei
https://github.com/beberlei/assert

- [x] Assertion::allIsInstanceOf(array(new \stdClass, new \stdClass), 'stdClass'); // success
- [x] Assertion::between(mixed $value, mixed $lowerLimit, mixed $upperLimit);
- [x] Assertion::boolean(mixed $value);
- [x] Assertion::count(array|Countable|ResourceBundle|SimpleXMLElement $countable, int $count);
- [x] Assertion::false(mixed $value);
- [x] Assertion::float(mixed $value);
- [x] Assertion::integer(mixed $value);
- [x] Assertion::isArray(mixed $value);
- [x] Assertion::isArrayAccessible(mixed $value);
- [x] Assertion::isCallable(mixed $value);
- [x] Assertion::isCountable(array|Countable|ResourceBundle|SimpleXMLElement $value);
- [x] Assertion::isInstanceOf(mixed $value, string $className);
- [x] Assertion::isObject(mixed $value);
- [x] Assertion::isResource(mixed $value);
- [x] Assertion::isTraversable(mixed $value);
- [x] Assertion::keyExists(mixed $value, string|int $key);
- [x] Assertion::keyNotExists(mixed $value, string|int $key);
- [x] Assertion::maxCount(array|Countable|ResourceBundle|SimpleXMLElement $countable, int $count);
- [x] Assertion::minCount(array|Countable|ResourceBundle|SimpleXMLElement $countable, int $count);
- [x] Assertion::null(mixed $value);
- [x] Assertion::numeric(mixed $value);
- [x] Assertion::objectOrClass(mixed $value);
- [x] Assertion::scalar(mixed $value);
- [x] Assertion::string(mixed $value);
- [x] Assertion::true(mixed $value);
- [ ] Assertion::alnum(mixed $value);
- [ ] Assertion::base64(string $value);
- [ ] Assertion::betweenExclusive(mixed $value, mixed $lowerLimit, mixed $upperLimit);
- [ ] Assertion::betweenLength(mixed $value, int $minLength, int $maxLength);
- [ ] Assertion::choice(mixed $value, array $choices);
- [ ] Assertion::choicesNotEmpty(array $values, array $choices);
- [ ] Assertion::classExists(mixed $value);
- [ ] Assertion::contains(mixed $string, string $needle);
- [ ] Assertion::date(string $value, string $format);
- [ ] Assertion::defined(mixed $constant);
- [ ] Assertion::digit(mixed $value);
- [ ] Assertion::directory(string $value);
- [ ] Assertion::e164(string $value);
- [ ] Assertion::email(mixed $value);
- [ ] Assertion::endsWith(mixed $string, string $needle);
- [ ] Assertion::eq(mixed $value, mixed $value2);
- [ ] Assertion::eqArraySubset(mixed $value, mixed $value2);
- [ ] Assertion::extensionLoaded(mixed $value);
- [ ] Assertion::extensionVersion(string $extension, string $operator, mixed $version);
- [ ] Assertion::file(string $value);
- [ ] Assertion::greaterOrEqualThan(mixed $value, mixed $limit);
- [ ] Assertion::greaterThan(mixed $value, mixed $limit);
- [ ] Assertion::implementsInterface(mixed $class, string $interfaceName);
- [ ] Assertion::inArray(mixed $value, array $choices);
- [ ] Assertion::integerish(mixed $value);
- [ ] Assertion::interfaceExists(mixed $value);
- [ ] Assertion::ip(string $value, int $flag = null);
- [ ] Assertion::ipv4(string $value, int $flag = null);
- [ ] Assertion::ipv6(string $value, int $flag = null);
- [ ] Assertion::isJsonString(mixed $value);
- [ ] Assertion::keyIsset(mixed $value, string|int $key);
- [ ] Assertion::length(mixed $value, int $length);
- [ ] Assertion::lessOrEqualThan(mixed $value, mixed $limit);
- [ ] Assertion::lessThan(mixed $value, mixed $limit);
- [ ] Assertion::max(mixed $value, mixed $maxValue);
- [ ] Assertion::maxLength(mixed $value, int $maxLength);
- [ ] Assertion::methodExists(string $value, mixed $object);
- [ ] Assertion::min(mixed $value, mixed $minValue);
- [ ] Assertion::minLength(mixed $value, int $minLength);
- [ ] Assertion::noContent(mixed $value);
- [ ] Assertion::notBlank(mixed $value);
- [ ] Assertion::notContains(mixed $string, string $needle);
- [ ] Assertion::notEmpty(mixed $value);
- [ ] Assertion::notEmptyKey(mixed $value, string|int $key);
- [ ] Assertion::notEq(mixed $value1, mixed $value2);
- [ ] Assertion::notInArray(mixed $value, array $choices);
- [ ] Assertion::notIsInstanceOf(mixed $value, string $className);
- [ ] Assertion::notNull(mixed $value);
- [ ] Assertion::notRegex(mixed $value, string $pattern);
- [ ] Assertion::notSame(mixed $value1, mixed $value2);
- [ ] Assertion::phpVersion(string $operator, mixed $version);
- [ ] Assertion::propertiesExist(mixed $value, array $properties);
- [ ] Assertion::propertyExists(mixed $value, string $property);
- [ ] Assertion::range(mixed $value, mixed $minValue, mixed $maxValue);
- [ ] Assertion::readable(string $value);
- [ ] Assertion::regex(mixed $value, string $pattern);
- [ ] Assertion::same(mixed $value, mixed $value2);
- [ ] Assertion::satisfy(mixed $value, callable $callback);
- [ ] Assertion::startsWith(mixed $string, string $needle);
- [ ] Assertion::subclassOf(mixed $value, string $className);
- [ ] Assertion::uniqueValues(array $values);
- [ ] Assertion::url(mixed $value);
- [ ] Assertion::uuid(string $value);
- [ ] Assertion::version(string $version1, string $operator, string $version2);
- [ ] Assertion::writeable(string $value);
- [ ] Assertion::nullOrMax(null, 42); // success


## Webmozarts
https://github.com/webmozarts/assert

Total: 19/25
- [x] boolean($value, $message = '')
- [x] float($value, $message = '')
- [x] integer($value, $message = '')
- [x] isAnyOf($value, array $classes, $message = '')
- [x] isAOf($value, $class, $message = '')
- [x] isArray($value, $message = '')
- [x] isArrayAccessible($value, $message = '')
- [x] isCallable($value, $message = '')
- [x] isCountable($value, $message = '')
- [x] isInstanceOf($value, $class, $message = '')
- [x] isInstanceOfAny($value, array $classes, $message = '')
- [x] isIterable($value, $message = '')
- [x] isTraversable($value, $message = '') (deprecated)
- [x] numeric($value, $message = '')
- [x] object($value, $message = '')
- [x] resource($value, $type = null, $message = '')
- [x] scalar($value, $message = '')
- [x] string($value, $message = '')
- [x] stringNotEmpty($value, $message = '')
- [ ] integerish($value, $message = '')
- [ ] isNotA($value, $class, $message = '')
- [ ] natural($value, $message= ''')
- [ ] notInstanceOf($value, $class, $message = '')
- [ ] positiveInteger($value, $message = '')
- [ ] uniqueValues($values, $message = '')

---

Total: 3/18
- [x] true($value, $message = '')
- [x] false($value, $message = '')
- [x] null($value, $message = '')
- [ ] notFalse($value, $message = '')
- [ ] notNull($value, $message = '')
- [ ] isEmpty($value, $message = '')
- [ ] notEmpty($value, $message = '')
- [ ] eq($value, $value2, $message = '')
- [ ] notEq($value, $value2, $message = '')
- [ ] same($value, $value2, $message = '')
- [ ] notSame($value, $value2, $message = '')
- [ ] greaterThan($value, $value2, $message = '')
- [ ] greaterThanEq($value, $value2, $message = '')
- [ ] lessThan($value, $value2, $message = '')
- [ ] lessThanEq($value, $value2, $message = '')
- [ ] range($value, $min, $max, $message = '')
- [ ] inArray($value, array $values, $message = '') // oneOf()
- [ ] oneOf($value, array $values, $message = '') // inArray()

---
Total: 0/25
- [ ] contains($value, $subString, $message = '')
- [ ] notContains($value, $subString, $message = '')
- [ ] startsWith($value, $prefix, $message = '')
- [ ] notStartsWith($value, $prefix, $message = '')
- [ ] startsWithLetter($value, $message = '')
- [ ] endsWith($value, $suffix, $message = '')
- [ ] notEndsWith($value, $suffix, $message = '')
- [ ] regex($value, $pattern, $message = '')
- [ ] notRegex($value, $pattern, $message = '')
- [ ] unicodeLetters($value, $message = '')
- [ ] alpha($value, $message = '')
- [ ] digits($value, $message = '')
- [ ] alnum($value, $message = '')
- [ ] lower($value, $message = '')
- [ ] upper($value, $message = '')
- [ ] length($value, $length, $message = '')
- [ ] minLength($value, $min, $message = '')
- [ ] maxLength($value, $max, $message = '')
- [ ] lengthBetween($value, $min, $max, $message = '')
- [ ] uuid($value, $message = '')
- [ ] ip($value, $message = '')
- [ ] ipv4($value, $message = '')
- [ ] ipv6($value, $message = '')
- [ ] email($value, $message = '')
- [ ] notWhitespaceOnly($value, $message = '')

---
Total: 0/5
- [ ] fileExists($value, $message = '')
- [ ] file($value, $message = '')
- [ ] directory($value, $message = '')
- [ ] readable($value, $message = '')
- [ ] writable($value, $message = '')

---
Total: 0/8
- [ ] classExists($value, $message = '')
- [ ] subclassOf($value, $class, $message = '')
- [ ] interfaceExists($value, $message = '')
- [ ] implementsInterface($value, $class, $message = '')
- [ ] propertyExists($value, $property, $message = '')
- [ ] propertyNotExists($value, $property, $message = '')
- [ ] methodExists($value, $method, $message = '')
- [ ] methodNotExists($value, $method, $message = '')

---
Total: 11/11
- [x] count($array, $number, $message = '')
- [x] countBetween($array, $min, $max, $message = '')
- [x] isList($array, $message = '')
- [x] isMap($array, $message = '')
- [x] isNonEmptyList($array, $message = '')
- [x] isNonEmptyMap($array, $message = '')
- [x] keyExists($array, $key, $message = '')
- [x] keyNotExists($array, $key, $message = '')
- [x] maxCount($array, $max, $message = '')
- [x] minCount($array, $min, $message = '')
- [x] validArrayKey($key, $message = '')

---
Total: 2/3
- [x] Assert::allIsInstanceOf($employees, 'Acme\Employee');
- [x] Assert::nullOrString($middleName, 'The middle name must be a string or null. Got: %s');
- [ ] throws($closure, $class, $message = '')
