<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\UserSession;
use App\Helpers\AuthHelper;
use App\Repository\UserSessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class ApiKeyAuthenticator extends AbstractGuardAuthenticator
{
    private $em;
    private $passwordEncoder;
    private $userSessionRepository;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder,
        UserSessionRepository $userSessionRepository)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->userSessionRepository = $userSessionRepository;
    }

    public function supports(Request $request): bool
    {
        return $request->headers->get(AuthHelper::API_KEY_HEADER_NAME);
    }

    public function getCredentials(Request $request)
    {
        return array(
            'api_key' => $request->headers->get(AuthHelper::API_KEY_HEADER_NAME),
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        if (null === $credentials) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"
            return null;
        }

        $userSessionRepository = $this->em->getRepository(UserSession::class);
        return $userSessionRepository->getUserByApiKey($credentials['api_key']);
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        // In case of an API token, no credential check is needed.
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new Response(
        // this contains information about *why* authentication failed
        // use it, or return your own message
            strtr($exception->getMessageKey(), $exception->getMessageData()),
            401
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey) : ?Response
    {
        // on success, let the request continue
        return null;
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new Response('Auth header required', Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe() :bool
    {
        return false;
    }
}
