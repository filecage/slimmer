<?php

    namespace Slimmer\Helper;

    use Creator\Creator;

    trait CreatorInjectionTrait {

        /**
         * @var Creator
         */
        private $creator;

        /**
         * @param Creator $creator
         *
         * @return $this
         */
        function injectCreator (Creator $creator) {
            $this->creator = $creator;

            return $this;
        }

        /**
         * @return Creator
         */
        function getCreator () {
            return $this->creator;
        }
        
    }