<?php
 declare (strict_types=1); namespace MailPoetVendor\Doctrine\DBAL\Types; if (!defined('ABSPATH')) exit; use MailPoetVendor\Doctrine\DBAL\ParameterType; use MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform; final class AsciiStringType extends \MailPoetVendor\Doctrine\DBAL\Types\StringType { public function getSQLDeclaration(array $column, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform) { return $platform->getAsciiStringTypeDeclarationSQL($column); } public function getBindingType() { return \MailPoetVendor\Doctrine\DBAL\ParameterType::ASCII; } public function getName() : string { return \MailPoetVendor\Doctrine\DBAL\Types\Types::ASCII_STRING; } } 