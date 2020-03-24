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
  class View {
    private static $vars = [];
    private static $sections = [];
    private static $open_sections = [];
    private static $bound_data = [];
    private static $base_dir = root . '/views';

    /**
     * Find and render a view with variables
     *
     * @param string $view path to view from the view directory, without the file extension
     * @param array $variables
     *
     */
    public static function render($view, $variables = array()) {
      $file_path = self::filePath($view);
      if ($extra_vars = self::getBoundData($view)) $variables = array_merge($variables, $extra_vars);
      self::$vars = array_merge(self::$vars, $variables);

      ob_start();
      extract(self::$vars);
      require "$file_path";
      echo ob_get_clean();
    }

    /**
     * Displays a defined section
     *
     * @param string $section_name section to display
     */
    public static function yield($section_name) {
      if (self::sectionExists($section_name)) echo self::$sections[$section_name];
    }

    /**
     * Creates a new section
     *
     * @param string $name
     */
    public static function section($name) {
      self::$open_sections[] = $name;
      ob_start();
    }

    /**
     * Indicates the end of a section
     */
    public static function endsection() {
      self::$sections[array_pop(self::$open_sections)] = ob_get_clean();
    }


    /**
     * Checks if a section exists
     * @param string $section_name
     * @return bool true if section exist otherwise false
     */
    public static function sectionExists($section_name) {
      return isset(self::$sections[$section_name]);
    }

    public static function extends($view) {
      ob_start();
      extract(self::$vars);
      extract(self::getBoundData($view));
      $path = self::filePath($view);
      include "$path";
      echo ob_get_clean();
    }

    /**
     * includes a view in another view
     * @param string $view
     * @param array $data
     */
    public static function include($view, $data = []) {
      ob_start();
      extract(self::$vars);
      extract($data);
      extract(self::getBoundData($view));
      $path = self::filePath($view);
      include "$path";
      echo ob_get_clean();
    }

    /**
     * Defines vars that can be accessible by other views by calling self::get($var_name)
     *
     * @param string $var_name
     * @param string $value
     */
    public static function set($var_name, $value) {
      self::$vars[$var_name] = htmlentities($value);
    }

    /**
     * Get a defined view var
     *
     * @param string $var_name name of the variable
     * @param string $default value to use if the variable was not declared
     * @return string
     */
    public static function get($var_name, $default = null) {
      return (isset(self::$vars[$var_name])) ? self::$vars[$var_name] : $default;
    }

    /**
     * Associate a set of data to a view anytime the view is loaded
     * @param string $view
     * @param Closure $callback Closure to return an associative array of values to be used by the view
     */
    public static function bindData($view, Closure $callback) {
      self::$bound_data[$view] = $callback;
    }

    private static function getBoundData($view) {
      if (!isset(self::$bound_data[$view])) return [];
      $meth = self::$bound_data[$view];
      $data = $meth();

      if (!is_array($data)) die(new Exception('Bound data for view \'' . $view . '\' should be an associative array of arguments, ' . gettype($data) . ' returned instead.'));
      return $data;
    }

    /**
     * Sets the base directory of all views
     * @param string $dir
     */
    public static function setBaseDir($dir) {
      self::$base_dir = rtrim($dir, '/\\ ');
    }

    /**
     * Gets the base directory for views
     * @return string
     */
    public static function getBaseDir() {
      return self::$base_dir;
    }

    /**
     * Escapes html to be displayed in view
     *
     * @param string $string
     * @return string
     */
    public static function e($string){
      return htmlspecialchars($string);
    }

    private static function filePath($view) {
      return self::$base_dir . DIRECTORY_SEPARATOR . $view . ".view.php";
    }
    
  }
