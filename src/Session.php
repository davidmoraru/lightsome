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
namespace Light;
    class Session {
        private static $sessionStarted = false;

        public static function set($key, $value) {
            $_SESSION[$key] = $value;
        }
        public static function get($key = null) {
            if($key) {
                if(isset($_SESSION[$key])) {
                    return $_SESSION[$key];
                }
            } else {
                return $_SESSION;
            }
        }
        public static function destroy($key = '')
        {
            if (self::$sessionStarted == true) {
                if ($key == '') {
                    session_unset();
                    session_destroy();
                } else {
                    unset($_SESSION[$key]);
                }
                return true;
            }
            return false;
        }
        public static function id() {
            return session_id();
        }
        public static function init($time = 3600)
    {
        if (self::$sessionStarted == false) {
            session_set_cookie_params($time);
            session_start();
            return self::$sessionStarted = true;
        }

        return false;
    }
        
    }