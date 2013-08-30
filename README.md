LightUserBundle
=============
Inspired by FOSUserBundle but much simpler. Perfect when you just need a simple user.

Important Note: This bundle is meant to work with Doctrine ORM only


# Installation

## Step 1 - Composer

    "ee/lightuser-bundle": "dev-master"

## Step 2 - Enable bundle

    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                [...]
                new EE\LightUserBundle\EELightUserBundle()
            );

        [...]

## Step 3 - Create User Entity

Get an annotated version [link](./Resources/doc/3-1_user_entity_annotations.md)

Get a yml version [link](./Resources/doc/3-2_user_entity_yml.md)

## Step 4 - Configuration

You must provide entity class (yup, that one from previous step)

    # app/config/config.yml

    ee_light_user:
        entity:
            user:
                class: Acme\DemoBundle\Entity\User

