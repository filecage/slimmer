<?php
    
    namespace Slimmer\Router;

    use Slimmer\Helper\CallHookTrait;
    use Slimmer\Helper\CreatorInjectionTrait;
    use Slimmer\Interfaces\CreatorInjectable;
    use Slimmer\Interfaces\Hookable;

    class Route implements Hookable, CreatorInjectable {
        use CallHookTrait, CreatorInjectionTrait;
    }