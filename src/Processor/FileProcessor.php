<?php
/**
 * Created by PhpStorm.
 * User: piotrzatorski
 * Date: 17/10/2018
 * Time: 18:16
 */

namespace App\Processor;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class FileProcessor
 *
 * @package App\Processor
 */
class FileProcessor
{
    /**
     * @var ParameterBagInterface
     */
    private $params;

    /**
     * FileProcessor constructor.
     *
     * @param ParameterBagInterface $params
     */
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @param array $results
     */
    public function logResultsToFile(array $results): void
    {
        $projectDir = $this->params->get('kernel.project_dir');
        $folder = '/public_html/';
        $fileName = 'log.txt';
        $path = sprintf('%s%s%s', $projectDir, $folder, $fileName);

        touch($path);

        $now = new \DateTime();

        $stringToAppend = sprintf(
                "[%s] URL: %s HTML LOAD TIME: %s[s]",
                $now->format('Y-m-d H:i:s'),
                $results['mainUrl'],
                $results['serverResposneTime']
        );

        if (count($results['additionalUrlsServerResponseTimes']) > 0) {
            $stringToAppend .= '| ADDITONAL URLS::: ';
            foreach ($results['additionalUrlsServerResponseTimes'] as $result) {
                $stringToAppend .= sprintf(
                        "[%s] URL: %s HTML LOAD TIME: %s[s] |",
                        $now->format('Y-m-d H:i:s'),
                        $result['url'],
                        $results['serverResposneTime']
                );
            }
        }

        $file = fopen($path, 'a');
        fwrite($file, $stringToAppend);
        fclose($file);
    }

}