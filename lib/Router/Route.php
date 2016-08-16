<?php
    
    namespace Slimmer\Router;

    use Slimmer\CallHookTrait;
    use Slimmer\CreatorInjectionTrait;
    use Slimmer\Interfaces\Hookable;

    class Route implements Hookable {
        use CallHookTrait, CreatorInjectionTrait;
    }