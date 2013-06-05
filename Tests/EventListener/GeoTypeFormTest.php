<?php

namespace PUGX\GeoFormBundle\Tests\EventListener;

use PUGX\GeoFormBundle\EventListener\GeoTypeForm;

class GeoTypeFormTest extends \PHPUnit_Framework_TestCase
{
    protected $formEvent;
    protected $form;
    protected $dataAdapter;
    protected $manager;
    protected $listener;
    protected $location;

    public function setUp()
    {
        $this->formEvent   = \Phake::mock('Symfony\Component\Form\FormEvent');
        //$this->getMockBuilder('Symfony\Component\Form\FormEvent')->disableOriginalConstructor()->getMock();

        $this->form        = \Phake::mock('Symfony\Component\Form\Form');
        //$this->getMockBuilder('Symfony\Component\Form\Form')->disableOriginalConstructor()->getMock();

        $this->dataAdapter =  \Phake::mock('PUGX\GeoFormBundle\Adapter\GeoDataAdapterInterface');
        //$this->getMockBuilder('PUGX\GeoFormBundle\Adapter\GeoDataAdapterInterface')->getMock();

        $this->manager     = \Phake::mock('PUGX\GeoFormBundle\Manager\GeoCodeManager');
        //$this->getMockBuilder('PUGX\GeoFormBundle\Manager\GeoCodeManager')->disableOriginalConstructor()->getMock();

        $this->location    = \Phake::mock('Geo\Location');
        //$this->getMockBuilder('Geo\Location')->disableOriginalConstructor()->getMock();

        $this->listener    = new GeoTypeForm($this->manager, $this->dataAdapter);
    }

    public function testOnFormPreSubmit()
    {
        $address = 'Via XYZ 22';
        $data = array(
            'address' => $address,
        );

        $this->listener->onFormPreSubmit($this->formEvent);

        /*$this->formEvent
            ->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($data));*/

        \Phake::when($this->formEvent)->getData()->thenReturn($data);

        /*$this->formEvent
            ->expects($this->once())
            ->method('getForm')
            ->will($this->returnValue($this->form));*/

        \Phake::when($this->formEvent)->getForm()->thenReturn($this->form);

        /*$this->dataAdapter
            ->expects($this->once())
            ->method('getFullAddress')
            ->with($data, $this->form)
            ->will($this->returnValue($address));*/

        \Phake::when($this->dataAdapter)->getFullAddress($data,$this->form)->thenReturn($address);

        /*$this->manager
            ->expects($this->once())
            ->method('query')
            ->with($address);*/

        \Phake::verify($this->manager)->query($address);

        /*$this->manager
            ->expects($this->once())
            ->method('getFirst')
            ->will($this->returnValue($this->location));*/

        \Phake::when($this->manager)->getFirst()->thenReturn($this->location);

        /*$this->location
            ->expects($this->once())
            ->method('getLatitude')
            ->will($this->returnValue(123));*/

        \Phake::when($this->location)->getLatitude()->thenReturn(123);

        /*$this->location
            ->expects($this->once())
            ->method('getLongitude')
            ->will($this->returnValue(456));*/

        \Phake::when($this->location)->getLongitude()->thenReturn(456);

        /*$this->formEvent
            ->expects($this->once())
            ->method('setData')
            ->with(array('address' => $address, 'latitude' => 123, 'longitude' => 456));*/

        \Phake::verify($this->formEvent)->setData(array('address' => $address, 'latitude' => 123, 'longitude' => 456));




    }
}
