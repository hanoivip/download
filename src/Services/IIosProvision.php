<?php
namespace Hanoivip\Download\Services;

interface IIosProvision
{
    public function registerDevice($udid);
    
    public function isDone($udid);
}