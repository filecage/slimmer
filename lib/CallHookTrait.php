<?php
    
    namespace Slimmer;
    
    use Creator\Creator;

    trait CallHookTrait {

        /**
         * @var callable[]
         */
        protected $registeredHooks = [];

        /**
         * @return Creator
         */
        abstract function getCreator();

        /**
         * @param string $hook
         * @param Buffer $buffer
         *
         * @return Buffer
         * @throws \Exception
         */
        function callHook($hook, Buffer $buffer) {
            if ($this->callHookFromRegistry($hook, $buffer) === null) {
                $this->callHookFromClassBody($hook, $buffer);
            }

            return $buffer;
        }

        /**
         * @param string $hook
         * @param callable $callable
         *
         * @return $this
         */
        function registerHook ($hook, callable $callable) {
            if (!isset($this->registeredHooks[$hook])) {
                $this->registeredHooks[$hook] = [];
            }

            $this->registeredHooks[$hook][] = $callable;

            return $this;
        }

        /**
         * @param string $hook
         * @param Buffer $buffer
         *
         * @return Buffer
         * @throws \Exception
         */
        private function callHookFromRegistry ($hook, Buffer $buffer) {
            if (!isset($this->registeredHooks[$hook])) {
                return null;
            }

            foreach ($this->registeredHooks[$hook] as $hookCallable) {
                $buffer = $this->callHookWithCallable($hookCallable, $buffer);
            }

            return $buffer;
        }

        /**
         * @param string $hook
         * @param Buffer $buffer
         *
         * @return $this|null
         */
        private function callHookFromClassBody ($hook, Buffer $buffer) {
            $hookMethodName = sprintf('%sHook', $hook);
            if (!method_exists($this, $hookMethodName)) {
                return null;
            }

            return $this->callHookWithCallable([$this, $hookMethodName], $buffer);
        }

        /**
         * @param callable $hookCallable
         * @param Buffer $buffer
         *
         * @return $this
         * @throws \Exception
         */
        private function callHookWithCallable (callable $hookCallable, Buffer $buffer) {
            $hookInvokable = $this->getCreator()->invokeInjected($hookCallable)->with($buffer);
            $hookResult = new Buffer($hookInvokable->invoke());

            return $buffer->mergeContents($hookResult);
        }

    }