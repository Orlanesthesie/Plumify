<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerW1XuWbO\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerW1XuWbO/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerW1XuWbO.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerW1XuWbO\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerW1XuWbO\App_KernelDevDebugContainer([
    'container.build_hash' => 'W1XuWbO',
    'container.build_id' => 'dc0446ec',
    'container.build_time' => 1727869839,
    'container.runtime_mode' => \in_array(\PHP_SAPI, ['cli', 'phpdbg', 'embed'], true) ? 'web=0' : 'web=1',
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerW1XuWbO');
