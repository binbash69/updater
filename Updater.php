<?php

class Updater
{
    /**
     * @var JoinsAutoloader
     */
    protected static $instance;

    /**
     * @var string Root directory
     */
    protected $root_dir;

    /**
     *  @var array array('classname' => 'path/to/override', 'classnamecore' => 'path/to/class/core')
     */
    public $index = array();

    
    protected function __construct($tmpDir)
    {
        $this->root_dir = $tmpDir;
        
    }

    /**
     * Get instance of autoload (singleton)
     *
     * @return Updater
     */
    public static function getInstance($tmpDir)
    {
        if (!Updater::$instance) {
            Updater::$instance = new Updater($tmpDir);
        }

        return Updater::$instance;
    }

    /**
    * Perform the update
    *
    * @param string $classname
    */
    public function checkForUpdate()
    {
        return "TODO";
 
    }

    /**
    * Perform the update
    *
    * @param string $classname
    */
    public function performUpdate()
    {
        //download the file and exctract it
        $this->downloadLastUpdate();

        //generate an index array for all the files to be updated
        $this->generateIndex();

        foreach($updater->index as $file){
            
            $newfile = str_replace($startPath, $rootDir, $file);
            //echo "Aggiornamento " . $file . "<br>";
        
            copy($file, $newfile);
        
       }
 
    }

    public function downloadLastUpdate(){

        $tmpFilename = _TMP_DIR_ . "/to_be_update.zip"; 

        file_put_contents($tmpFilename, fopen("http://development.joins.ch/updater-test/update_012.zip", 'r'));

        $zip = new ZipArchive;
        $res = $zip->open($tmpFilename);
        if ($res === TRUE) {
          $zip->extractTo( _TMP_DIR_ . "/extract_path/");
          $zip->close();
        }
    }

    /**
     * Generate classes index
     */
    public function generateIndex()
    {
        $files = $this->getClassesFromDir('Core/classes/');

        //ddd("Index");

        ksort($files);

        $this->index = $files;
    }

    /**
     * Retrieve recursively all classes in a directory and its subdirectories
     *
     * @param string $path Relativ path from root to the directory
     * @return array
     */
    protected function getClassesFromDir($path, $host_mode = false)
    {
        
        $classes = array();
        $root_dir = $this->root_dir;

        foreach (scandir($root_dir.$path) as $file) {
            if ($file[0] != '.') {
                //exclude
                
                if (is_dir($root_dir.$path.$file)) {
                    $classes = array_merge($classes, $this->getClassesFromDir($path.$file.'/', $host_mode));
                } else{

                    $classes[] = $root_dir.$path.$file;/*
                    $content = file_get_contents($root_dir.$path.$file);

                    $namespacePattern = '[\\a-z0-9_]*[\\]';
                    $pattern = '#\W((abstract\s+)?class|interface)\s+(?P<classname>'.basename($file, '.php').'(?:Core)?)'
                                .'(?:\s+extends\s+'.$namespacePattern.'[a-z][a-z0-9_]*)?(?:\s+implements\s+'.$namespacePattern.'[a-z][\\a-z0-9_]*(?:\s*,\s*'.$namespacePattern.'[a-z][\\a-z0-9_]*)*)?\s*\{#i';

                    if (preg_match($pattern, $content, $m)) {
                        $classes[$m['classname']] = array(
                            'path' => $path.$file,
                            'type' => trim($m[1]),
                            'override' => $host_mode
                        );
                        
                        if (substr($m['classname'], -4) == 'Core') {
                            $classes[substr($m['classname'], 0, -4)] = array(
                                'path' => '',
                                'type' => $classes[$m['classname']]['type'],
                                'override' => $host_mode
                            );
                        }
                    }*/
                }
                
            }
        }

        return $classes;
    }

    public function getClassPath($classname)
    {
        return (isset($this->index[$classname]) && isset($this->index[$classname]['path'])) ? $this->index[$classname]['path'] : null;
    }

    private function normalizeDirectory($directory)
    {
        return rtrim($directory, '/\\').DIRECTORY_SEPARATOR;
    }
}
