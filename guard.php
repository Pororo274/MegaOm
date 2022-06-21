<?php

function isCanSee($urole, $target) {
  for ($i = 0; $i < count($target); $i++) {
    if ($urole == $target[$i]) {
      return true;
    }
  }
  return false;
}

?>