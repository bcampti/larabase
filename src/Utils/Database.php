<?php 
namespace Bcampti\Larabase\Utils;

use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class Database
{

    protected $connection = "landlord";

    /**
     * Check to see if a table exists within a schema
     *
     * @param string $schemaName
     * @param string $tableName
     *
     * @return bool
     */
    public function tableExists($schemaName, $tableName)
    {
        $tables = DB::connection($this->connection)->table('information_schema.tables')
            ->select('table_name')
            ->where('table_schema', '=', $schemaName)
            ->where('table_name', '=', $tableName)
            ->get();
        
        if( count($tables)>0 ){
            return true;
        }
        return false;
    }

    /**
     * Check to see if a schema exists
     *
     * @param string $schemaName
     *
     * @return bool
     */
    public function schemaExists($schemaName)
    {
        $schema = DB::connection($this->connection)->table('information_schema.schemata')
            ->select('schema_name')
            ->where('schema_name', '=', $schemaName)
            ->count();

        return ($schema > 0);
    }

    /**
     * Create a new schema
     *
     * @param string $schemaName
     */
    public function createSchema($schemaName)
    {
        $query = DB::connection($this->connection)->statement('CREATE SCHEMA ' . $schemaName);
    }

    public function generateSchemaName()
    {
        $string = trim(strtolower( Uuid::uuid4()->toString() ));

        $string = "connectspot_". $string;

        $dict = array(
            "ltda"=>"",
            "."=> "",
        );
        $string = strLower(
            preg_replace(
                array('#[\\s-]+#', '#[^A-Za-z0-9\. _]+#'),
                array('_', ''),

                $this->cleanString(
                    trim(
                        str_replace( // preg_replace can be used to support more complicated replacements
                            array_keys($dict),
                            array_values($dict),
                            urldecode($string)
                        )
                    )
                )
            )
        );

        return $string;
    }

    public function cleanString($text)
    {
        $utf8 = array(
            '/[áàâãªä]/u'   =>   'a',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏ]/u'     =>   'I',
            '/[íìîï]/u'     =>   'i',
            '/[éèêë]/u'     =>   'e',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºö]/u'   =>   'o',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûü]/u'     =>   'u',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/ç/'           =>   'c',
            '/Ç/'           =>   'C',
            '/ñ/'           =>   'n',
            '/Ñ/'           =>   'N',
            '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
            '/[“”«»„]/u'    =>   ' ', // Double quote
            '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
        );
        return preg_replace(array_keys($utf8), array_values($utf8), $text);
    }

}