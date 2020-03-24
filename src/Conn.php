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
    class Connect {
        const DB_FILE = root . '/database/sqlite.db';
        private static $conn;
        private static $default_result;
        private static $results;

        public static function connect() {
            if (self::$conn == null) {
                try {
                    self::$conn = new \PDO("sqlite:" . self::DB_FILE);
                } catch (\PDOException $e) {
                    throw new \Exception ('Connection failed: ' . $e->getMessage());
                }
            }
            self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return self::$conn;
        }

        public static function close() {
            self::$conn == null;
        }
        private static function set_handle( $result = NULL, $handle = '' )
        {
            if( !$result )
                return false;
            
            if( !$handle )
                self::$default_result = $result;
            else
                self::$results[strval($handle)] = $result;
                
            return true;
        }
        public static function query($query, $handle = '', $ignore_count = TRUE )
        {
            //if query was a 'SELECT', perform the query,
            //return the number of returned rows
            if( preg_match( '%^(select)%is', $query ) > 0 )
            {
                try
                {	
                    //perform the query
                    $result = self::$conn->query( $query ); //PDO query method for result
                }
                catch (PDOException $e )
                {
                    //throw general exception
                    throw new Exception( 'SQLite3Database: '.$e->getMessage().' Query: '.$query );
                }
                
                //add count to the result
                if( $ignore_count != TRUE )
                    $result->count = self::$conn->rowCount();
                else
                    $result->count = 1;
                
                //save the handle of this query
                self::set_handle( $result, $handle );
                
                //return number of rows
                return $result->count;
            }
            else //Else query was an operation
            {
                try
                {
                    //perform the query
                    $result = self::$conn->exec( $query ); //PDO exec method
                }
                catch (\PDOException $e )
                {
                    //throw general exception
                    throw new \Exception( 'Db: '.$e->getMessage().' Query: '.$query );
                }				
                
                //if query was one that affected existing rows (ie UPDATE, DELETE etc), return the number of affected rows
                if( preg_match( '%^(update|replace|delete)%is', $query ) > 0 )
                {
                    return $result; //PDO automatically returns the number of affected rows as result
                }
                //if query was an insert, return the new ID
                elseif( preg_match( '%^(insert)%is', $query ) > 0 )
                {
                    return self::$conn->lastInsertId();
                }
            }
            return TRUE;
        }
    }