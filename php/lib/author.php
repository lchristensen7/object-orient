<?php
namespace lchristensen7\ObjectOrient;
use Ramsey\Uuid\Uuid;
require_once("../Classes/Author.php");

$author = new Author("efb89399-bd0b-47b7-9ced-dc82027879b0","https://bootcamp-coder.cnm.edu","abcdefghijklmnaopqrstuvxyz123400","lchristensen7@cnm.edu",'$argon2i$v=19$m=1024,t=384,p=2$dE55dm5kRm9DTEYxNFlFUA$nNEMItrDUtwnDhZ41nwVm7ncBLrJzjh5mGIjj8RlzVA',"lchristensen7");

var_dump($author);

?>