<?php

class Sesion
{

 public string $cue;
 public array $rolIds;

 public function __construct(string $cue, array $rolIds)
 {
  $this->cue = $cue;
  $this->rolIds = $rolIds;
 }
}
