<?php

require_once 'Item.php';

$item = new Item(1);

$item->id; 
$item->name = 'tratrata';
$item->status = 1;

if ( $item->save() ) {
  echo 'Данные успешно сохранены!';
}