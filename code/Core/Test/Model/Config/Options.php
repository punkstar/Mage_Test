<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Magento
 * @package     Mage_Core
 * @subpackage  Test
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Mage_Core_Test_Model_Config_Options extends Mage_Test_Unit_Case
{
    /**
     * @var Mage_Core_Model_Config_Options
     */
    protected $_model;

    protected static $_keys = array(
        'app_dir'     => 'app',
        'base_dir'    => 'base',
        'code_dir'    => 'code',
        'design_dir'  => 'design',
        'etc_dir'     => 'etc',
        'lib_dir'     => 'lib',
        'locale_dir'  => 'locale',
        'js_dir'      => 'js',
        'media_dir'   => 'media',
        'var_dir'     => 'var',
        'tmp_dir'     => 'tmp',
        'cache_dir'   => 'cache',
        'log_dir'     => 'log',
        'session_dir' => 'session',
        'upload_dir'  => 'upload',
        'export_dir'  => 'export',
    );

    protected function setUp()
    {
        $this->_model = new Mage_Core_Model_Config_Options;
    }

    public function testConstruct()
    {
        $data = $this->_model->getData();
        foreach (array_keys(self::$_keys) as $key) {
            $this->assertArrayHasKey($key, $data);
            unset($data[$key]);
        }
        $this->assertEmpty($data);
    }

    public function testGetDir()
    {
        foreach (self::$_keys as $full => $partial) {
            $this->assertEquals($this->_model->getData($full), $this->_model->getDir($partial));
        }
    }

    /**
     * @expectedException Mage_Core_Exception
     */
    public function testGetDirException()
    {
        $this->_model->getDir('invalid');
    }

    /**
     * @covers Mage_Core_Model_Config_Options::getAppDir
     * @covers Mage_Core_Model_Config_Options::getBaseDir
     * @covers Mage_Core_Model_Config_Options::getCodeDir
     * @covers Mage_Core_Model_Config_Options::getDesignDir
     * @covers Mage_Core_Model_Config_Options::getEtcDir
     * @covers Mage_Core_Model_Config_Options::getLibDir
     * @covers Mage_Core_Model_Config_Options::getLocaleDir
     * @covers Mage_Core_Model_Config_Options::getMediaDir
     * @covers Mage_Core_Model_Config_Options::getSysTmpDir
     * @covers Mage_Core_Model_Config_Options::getVarDir
     * @covers Mage_Core_Model_Config_Options::getTmpDir
     * @covers Mage_Core_Model_Config_Options::getCacheDir
     * @covers Mage_Core_Model_Config_Options::getLogDir
     * @covers Mage_Core_Model_Config_Options::getSessionDir
     * @covers Mage_Core_Model_Config_Options::getUploadDir
     * @covers Mage_Core_Model_Config_Options::getExportDir
     */
    public function testGetters()
    {
        $this->assertTrue(is_dir($this->_model->getAppDir()), "App directory does not exist.");
        $this->assertTrue(is_dir($this->_model->getBaseDir()), "Base directory does not exist.");
        $this->assertTrue(is_dir($this->_model->getCodeDir()), "Code directory does not exist.");
        $this->assertTrue(is_dir($this->_model->getDesignDir()), "Design directory does not exist.");
        $this->assertTrue(is_dir($this->_model->getEtcDir()), "Etc directory does not exist.");
        $this->assertTrue(is_dir($this->_model->getLibDir()), "Lib directory does not exist.");
        $this->assertTrue(is_dir($this->_model->getLocaleDir()), "Locale directory does not exist.");
        $this->assertTrue(is_dir($this->_model->getMediaDir()), "Media directory does not exist.");
        $this->assertTrue(is_dir($this->_model->getSysTmpDir()), "System temporary directory does not exist.");
        $this->assertTrue(is_dir($this->_model->getVarDir()), "Var directory does not exist.");
        $this->assertTrue(is_dir($this->_model->getTmpDir()), "Temporary directory does not exist.");
        $this->assertTrue(is_dir($this->_model->getCacheDir()), "Cache directory does not exist.");
        $this->assertTrue(is_dir($this->_model->getLogDir()), "Log directory does not exist.");
        $this->assertTrue(is_dir($this->_model->getSessionDir()), "Session directory does not exist.");
        $this->assertTrue(is_dir($this->_model->getUploadDir()), "Upload directory does not exist.");
        $this->assertTrue(is_dir($this->_model->getExportDir()), "Export directory does not exist.");
    }

    public function testCreateDirIfNotExists()
    {
        $var = $this->_model->getVarDir();

        $sampleDir = uniqid($var);
        $this->assertTrue($this->_model->createDirIfNotExists($sampleDir));
        $this->assertTrue($this->_model->createDirIfNotExists($sampleDir));
        rmdir($sampleDir);

        $sampleFile = "{$var}/" . uniqid('file') . '.txt';
        file_put_contents($sampleFile, '1');
        $this->assertFalse($this->_model->createDirIfNotExists($sampleFile));
        unlink($sampleFile);
    }
}
