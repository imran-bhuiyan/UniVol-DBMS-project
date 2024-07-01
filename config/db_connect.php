<?php 

// connect to database

$conn = mysqli_connect('localhost','project','test123','projecton');

if(!$conn)
{
   echo 'Connection error : '. mysqli_connect_error();
}


 ?>