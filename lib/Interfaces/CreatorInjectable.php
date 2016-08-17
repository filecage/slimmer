<?php

    namespace Slimmer;

    use Creator\Creator;

    interface CreatorInjectable {

        /**
         * @param Creator $creator
         */
        function injectCreator (Creator $creator);

    }