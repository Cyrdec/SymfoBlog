<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use App\Repository\ParametreRepository;

/**
 * Description of GenericController
 *
 * @author cedric
 */
class GenericController extends AbstractController
{
    /**
     * @param string
     */
    protected $skin;
    
    public function myRender(string $template, array $params): Response
    {
        
        $params = array_merge($params, ['skin' => $this->skin]);
        
        $params = array_merge($params, ['imgLogo' => $this->siteParams['parameters']['logo.image']]);
        $params = array_merge($params, ['labelLogo' => $this->siteParams['parameters']['logo.label']]);
        
        return $this->render($this->skin.$template, $params);
    }
    
    public function sendMail(array $to, ?array $cc, ?array $ccc,
            string $sujet, string $html, string $from = 'no-reply@gesparc.fr', string $replyTo = null): bool 
    {
        try {
            $email = (new Email())
                    ->from($from)
                    ->to(...$to)
                    ->priority(Email::PRIORITY_NORMAL)
                    ->subject($sujet)
                    ->html($html);

            if ($cc !== null) {
                $email->cc(...$cc);
            }
            if ($ccc !== null) {
                $email->bcc(...$ccc);
            }
            if ($replyTo !== null) {
                $email->replyTo($replyTo);
            }

            $this->mailer->send($email);
        } catch (\Exception $e) {
            $this->logger->error('[' . $e->getCode() . '] ' . $e->getMessage());
            $this->logger->error($e->getTraceAsString());
            return false;
        }
        return true;
    }
    
    /**
     * 
     * @param MailerInterface $mailer
     * @param LoggerInterface $logger
     * @param ParametreRepository $paramRepository
     */
    public function __construct(MailerInterface $mailer, LoggerInterface $logger, ParametreRepository $paramRepository) {
        $this->siteParams = Yaml::parseFile('../config/site.yaml');
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->paramRepository = $paramRepository;
        
        $skinName = $this->siteParams['parameters']['app.params.skin'];
        $this->skin = $this->paramRepository->findOneBy(['cle' => $skinName])->getValeur();
    }
    
    /**
     * @var LoggerInterface 
     */
    private $logger;
    /**
     * @var MailerInterface 
     */
    private $mailer;
    /**
     * @var array
     */
    private $siteParams;
    /**
     * @var ParametreRepository 
     */
    protected $paramRepository;
    
}
