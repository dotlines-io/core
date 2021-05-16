<?php


namespace Dotlines\Core\Interfaces;

interface IRequest
{
    public function params(): array;
    public function headers(): array;
    public function send(): array;
}
