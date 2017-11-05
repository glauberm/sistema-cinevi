<?php

namespace Cinevi\AdminBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;

// exit(var_dump("<pre>",\Doctrine\Common\Util\Debug::dump(),"</pre>"));

abstract class RestfulCrudController extends RestfulDeleteController implements ClassResourceInterface
{

}
