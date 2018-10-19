<?php
/**
 * Created by PhpStorm.
 * User: piotrzatorski
 * Date: 17/10/2018
 * Time: 18:16
 */

namespace App\Processor;


use App\Helper\RequestHelper;
use App\Request\Request as AppRequest;
use GuzzleHttp\TransferStats;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestProcessor
{
    /**
     * @var RequestHelper
     */
    private $requestHelper;

    /**
     * @var float|null
     */
    private $serverResponseTime;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * RequestProcessor constructor.
     *
     * @param RequestHelper $requestHelper
     */
    public function __construct(RequestHelper $requestHelper, RequestStack $requestStack)
    {
        $this->requestHelper = $requestHelper;
        $this->requestStack = $requestStack;
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getServerResponseTimes()
    {
        $request = $this->requestStack->getCurrentRequest();
        $mainUrl = $request->request->get('main');
        $additionalUrls = \explode('_-_-_', $request->request->get('additionalUrls'));
        unset($additionalUrls[count($additionalUrls) - 1]);
        $appRequest = new AppRequest($mainUrl);
        $serverResposneTime = $this->getServerResponseTime($appRequest); //seconds

        $mailAlert = false;
        $smsAlert = false;

        $additionalUrlsServerResponseTimes = [];
        foreach ($additionalUrls as $additionalUrl) {
            $appRequest = new AppRequest($additionalUrl);
            $resposneTime = $this->getServerResponseTime($appRequest); //seconds
            $additionalUrlsServerResponseTimes[] = [
                    'serverResposneTime' => $resposneTime,
                    'url'                => $additionalUrl,
            ];
            if ($resposneTime < $serverResposneTime) {
                $mailAlert = $request->request->get('email');
            }
            if ($resposneTime * 2 < $serverResposneTime) {
                $smsAlert = $request->request->get('phoneNumber');
            }
        }

        return [
                'mainUrl'                           => $mainUrl,
                'serverResposneTime'                => $serverResposneTime,
                'additionalUrlsServerResponseTimes' => $additionalUrlsServerResponseTimes,
                'mailAlert'                         => $mailAlert,
                'smsAlert'                          => $smsAlert,
        ];
    }

    /**
     * @param AppRequest $request
     *
     * @return float|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getServerResponseTime(AppRequest $request): ?float
    {

        $this->requestHelper->setRequest($request);
        $this->requestHelper->checkUrl();
        $this->serverResponseTime = 0;
        $request->getClient()->get(
                $request->getUrl(),
                [
                        'on_stats' => function(TransferStats $stats) {

                            $totalTime = $stats->getHandlerStats()['total_time'];
                            if ($this->serverResponseTime < $totalTime) {
                                $this->serverResponseTime = $totalTime;
                            }
                        },
                ]
        );

        return $this->serverResponseTime;
    }

}