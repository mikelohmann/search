<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\Search;

use Doctrine\Search\Mapping\Driver\Driver;
use Doctrine\Common\Cache\Cache;

/**
 * Configuration SearchManager
 *
 * @license http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @author  Mike Lohmann <mike.h.lohmann@googlemail.com>
 */
class Configuration
{
    /**
     *
     * Holds the attributes for the search configuration
     * @var array $attributes
     */
    private $attributes;

    /**
     * Gets the cache driver implementation that is used for the mapping metadata.
     * (Annotation is the default)
     *
     * @return Mapping\Driver\Driver
     */
    public function getMetadataDriverImpl()
    {
        if (!isset($this->attributes['concreteMetadataDriver'])) {
            $this->attributes['concreteMetadataDriver'] = $this->newDefaultAnnotationDriver();
        }

        return $this->attributes['concreteMetadataDriver'];
    }

    /**
     * Sets the driver that is used to store the class metadata .
     *
     * @param Driver $concreteDriver
     */
    public function setMetadataDriverImpl(Driver $concreteDriver)
    {
        $this->attributes['concreteMetadataDriver'] = $concreteDriver;
    }

    /**
     * Sets the cache driver that is used to cache the metadata.
     *
     * @param \Doctrine\Common\Cache\Cache $concreteCache
     */
    public function setMetadataCacheImpl(Cache $concreteCache)
    {
        $this->attributes['metadataCacheImpl'] = $concreteCache;
    }

    /**
     * Returns the cache driver that is used to cache the metadata.
     *
     * @return \Doctrine\Common\Cache\Cache
     */
    public function getMetadataCacheImpl()
    {
        return $this->attributes['metadataCacheImpl'];
    }

    /**
     * Add a new default annotation driver with a correctly configured annotation reader.
     *
     * @param array $paths
     * @return Mapping\Driver\AnnotationDriver
     */
    public function newDefaultAnnotationDriver(array $paths = array())
    {
        $reader = new \Doctrine\Common\Annotations\AnnotationReader();

        return new \Doctrine\Search\Mapping\Driver\AnnotationDriver($reader, $paths);
    }

    /**
     * Set the class metadata factory class name.
     *
     * @param string $cmf
     */
    public function setClassMetadataFactoryName($cmfName)
    {
        $this->attributes['classMetadataFactoryName'] = $cmfName;
    }

    /**
     * Gets the class metadata factory class name.
     *
     * @return string
     */
    public function getClassMetadataFactoryName()
    {
        if (!isset($this->attributes['classMetadataFactoryName'])) {
            $this->attributes['classMetadataFactoryName'] = 'Doctrine\Search\Mapping\ClassMetadataFactory';
        }
        return $this->attributes['classMetadataFactoryName'];
    }

    /**
     * Gets the class metadata factory.
     *
     * @return Doctrine\Common\AbstractClassMetadataFactory
     */
    public function getClassMetadataFactory()
    {
        if (!isset($this->attributes['classMetadataFactory'])) {
            $classMetaDataFactoryName = $this->getClassMetadataFactoryName();
            $this->attributes['classMetadataFactory'] = new $classMetaDataFactoryName;
        }
        return $this->attributes['classMetadataFactory'];
    }

}