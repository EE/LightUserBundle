Authenticating with Google
==================
Simple recipe how to configure Google OAuth Authentication to work with EE/LightUserBundle

Things to know before continuing

This recipe:
- uses HWI/OAuthBundle
- uses email as username
- uses yml configuration for entities

Potential issues
- @TODO

### Mass Replace
To avoid typos and speedup your work you can mass replace certain strings so they can be copy pasted without modifying.
Open this file in editor of your choice and mass replace following strings

    acme_demo
    Acme\DemoBundle


## Install HWI/OAuthBundle

**composer**

    "hwi/oauth-bundle": "dev-master"

**app/AppKernel.php**

    new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),


## Configure project

**app/config/parameters.yml**

    oauth_google_client_id: [enter client id here]
    oauth_google_client_secret: [enter client secret here]

**app/config/parameters.yml.dist**

    oauth_google_client_id:
    oauth_google_client_secret:

**app/config/config.yml**

    hwi_oauth:
        firewall_name: secured_area
        resource_owners:
            google:
                type:                google
                client_id:           %oauth_google_client_id%
                client_secret:       %oauth_google_client_secret%
                scope:               "https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile"

**app/config/security.yml**

    security:
        firewalls:
            secured_area:
                oauth:
                    resource_owners:
                        google:             "/login/check-google"
                    login_path:        /
                    failure_path:      / # path that will be loaded after authentication failure
                    oauth_user_provider:
                        service: acme_demo.oauth_user_provider
                anonymous: ~

**app/config/routing.yml**

    hwi_oauth_redirect:
        resource: "@HWIOAuthBundle/Resources/config/routing/redirect.xml"
        prefix:   /connect

    google_login:
        pattern: /login/check-google


**Acme\DemoBundle\Entity\User**

properties

    /**
     * @var string
     */
    protected $googleId;

    /**
     * @var string
     */
    protected $googleAccessToken;

setters and getters

    /**
     * @param string $googleId
     *
     * @return $this
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * @param string $googleAccessToken
     *
     * @return $this
     */
    public function setGoogleAccessToken($googleAccessToken)
    {
        $this->googleAccessToken = $googleAccessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getGoogleAccessToken()
    {
        return $this->googleAccessToken;
    }

**Acme\DemoBundle\Resources\config\doctrine\User.orm.yml**

    Acme\DemoBundle\Entity\User:
        type: entity
        table: null
        fields:
            id:
                type: integer
                id: true
                generator:
                    strategy: AUTO
            googleId:
                type: string
            googleAccessToken:
                type: string
        lifecycleCallbacks: {  }

**Acme\DemoBundle\Security\Core\User\OAuthUserProvider.php**

    <?php

    namespace Acme\DemoBundle\Security\Core\User;

    use EE\LightUserBundle\Security\Core\User\UserProvider;
    use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
    use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
    use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

    /**
     * Class OAuthUserProvider
     */
    class OAuthUserProvider extends UserProvider implements OAuthAwareUserProviderInterface
    {

        /**
         * {@inheritdoc}
         */
        public function loadUserByOAuthUserResponse(UserResponseInterface $response)
        {

            $username = $response->getUsername();
            $service = $response->getResourceOwner()->getName();

            // we want to use email address as username
            $serviceUsername = $response->getEmail();

            try {
                $user = $this->loadUserByUsername($serviceUsername);
            } catch (UsernameNotFoundException $e) {

                $user = $this->userManager->createUser();

                $setter = 'set' . ucfirst($service);
                $setterId = $setter . 'Id';
                $setterToken = $setter . 'AccessToken';

                $user->setUsername($serviceUsername);

                $user->$setterId($username);
                $user->$setterToken($response->getAccessToken());

                $this->userManager->updateUser($user);

            }

            return $user;
        }
    }

**Acme\DemoBundle\Resources\config\services.yml**

    parameters:
        acme_demo.oauth_user_provider.class:   Acme\DemoBundle\Security\Core\User\OAuthUserProvider

    services:
        acme_demo.oauth_user_provider:
            class: "%acme_demo.oauth_user_provider.class%"
            arguments: ["@ee_light_user.user_manager"]
