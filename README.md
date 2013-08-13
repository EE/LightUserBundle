LightUserBundle
=============
Inspired by FOSUserBundle but much simpler. Perfect when you just need a simple user.

Documentation in development, stay tuned!


## Installation

### Step 1 - Composer

    "ee/lightuser-bundle": "dev-master"

### Step 2 - Enable bundle

    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                [...]
                new EE\LightUserBundle\EELightUserBundle()
            );

        [...]

### Configuration

You must provide entity class

    # app/config/config.yml

    ee_light_user:
        entity:
            user:
                class: Acme\DemoBundle\Entity\User

