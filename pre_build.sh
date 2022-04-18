#!/bin/bash

## 校验 composer.json 
composer validate --strict

## 修复错误
vendor/bin/phpstan analyse app tests

## 修正语法
vendor/bin/php-cs-fixer fix --verbose