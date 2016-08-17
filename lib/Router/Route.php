<?php
    
    namespace Slimmer\Router;

    use Slimmer\CallHookTrait;
    use Slimmer\CreatorInjectable;
    use Slimmer\CreatorInjectionTrait;
    use Slimmer\Interfaces\Hookable;

    class Route implements Hookable, CreatorInjectable {
        use CallHookTrait, CreatorInjectionTrait;
    }