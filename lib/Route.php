<?php
    
    namespace Slimmer;

    use Slimmer\Interfaces\Hookable;

    class Route implements Hookable {
        use CallHookTrait, CreatorInjectionTrait;
    }