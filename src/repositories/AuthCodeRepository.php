<?php
/**
 * File "AuthCodeRepository.php"
 * @author Thomas Bourrely
 * 20/07/2017
 */

namespace server\repositories;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use \League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

use server\models\AuthCode;
use server\entities\AuthCode as AuthCodeEntity;

/**
 * Class AuthCodeRepository
 *
 * @package server\repositories
 */
class AuthCodeRepository implements AuthCodeRepositoryInterface
{

    /**
     * @return AuthCodeEntity
     */
    public function getNewAuthCode()
    {
        return new AuthCodeEntity( new AuthCode() );
    }

    /**
     * @param AuthCodeEntityInterface $authCodeEntity
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        $authCodeModel = AuthCode::firstOrNew(['authorization_code' => $authCodeEntity->getIdentifier()]);

        if ( empty( $authCodeModel->redirect_uri ) ) {

            $authCodeModel->client_id = $authCodeEntity->getClient()->getIdentifier();
            $authCodeModel->user_id = $authCodeEntity->getUserIdentifier();
            $authCodeModel->redirect_uri = $authCodeEntity->getRedirectUri();
            $authCodeModel->expire_date = $authCodeEntity->getExpiryDateTime()->format('Y-m-d H:i:s');
            $authCodeModel->scope_id = $authCodeEntity->stringScopes();

            $authCodeModel->save();
        }
    }

    /**
     * @param string $codeId
     */
    public function revokeAuthCode($codeId)
    {
        AuthCode::where( 'authorization_code', '=', $codeId )->delete();
    }

    /**
     * @param string $codeId
     * @return bool
     */
    public function isAuthCodeRevoked($codeId)
    {
        $code = AuthCode::where( 'authorization_code', '=', $codeId )->first();

        if ( empty( $code->authorization_code ) )
            return true;

        return false;
    }
}