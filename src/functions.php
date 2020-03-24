<?php
/*!
 * Lightsome
 * Copyright (C) 2012-2016 David Andrei.
 * https://github.com/davidmoraru/lightsome
 *
 * Lightsome is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; version 3 only.
 *
 * Lightsome is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Lightsome. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Shortcut to the Som::get() method.
 *
 * @param string $route
 * @param mixed Callback $function
 */
function get($route, $function)
{
    Some::get($route, $function);
}

/**
 * Shortcut to the Some::post() method.
 *
 * @param string $route
 * @param mixed Callback $function
 */
function post($route, $function)
{
    Som::post($route, $function);
}

/**
 * Shortcut to the Som::put() method.
 *
 * @param string $route
 * @param mixed Callback $function
 */
function put($route, $function)
{
    Som::put($route, $function);
}

/**
 * Shortcut to the Som::patch() method.
 *
 * @param string $route
 * @param mixed Callback $function
 */
function patch($route, $function)
{
    Som::patch($route, $function);
}

/**
 * Shortcut to the Som::delete() method.
 *
 * @param string $route
 * @param mixed Callback $function
 */
function delete($route, $function)
{
    Som::delete($route, $function);
}
