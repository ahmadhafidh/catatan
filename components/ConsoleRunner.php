<?php

namespace app\components;

use Yii;
use yii\base\Component;

class ConsoleRunner extends Component
{
    /**
     * @var string yii console application file that will be executed
     */
    public $yiiscript = "@app/yii";

    /**
     * @var string path to php executable
     */
    public $phpexec;

    /**
     * @var bool whether it'll run in background
     */
    public $runInBackground = true;

    /**
     * @var bool whether it'll throw output from command with default stderr and stdout
     */
    public $useDevNull = true;

    /**
     * @var bool whether it'll activate linux's No Hang Up command
     */
    public $useLinuxNoHangUp = true;

    /**
     * @var string default template to execute command
     */
    public $template = "{noHangUp} {windowsRun} {windowsBackground} {php} {yii} {command} {dump} {linuxBackground}";

    /**
     * @var string windows dump command
     */
    public $windowsDump = '';

    /**
     * @var string linux dump command
     */
    public $linuxDump = '';


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        set_time_limit(0);
    }

    /**
     * Runs yii console command
     *
     * @param $cmd command with arguments
     * @param string $output filled with the command output
     * @return int termination status of the process that was run
     */
    public function run($cmd, &$output = '')
    {
        $handler = popen($this->buildCommand($cmd), 'r');

        while(!feof($handler))
            $output .= fgets($handler);

        $output = trim($output);
        $status = pclose($handler);

        return $status;
    }

    /**
     * Builds the command string
     *
     * @param $cmd Yii command
     * @return string full command to execute
     */
    protected function buildCommand($cmd)
    {
        $this->replaceTemplateTokens([
            '{noHangUp}' => $this->isWindows() ? '' : ($this->useLinuxNoHangUp ? (PHP_OS == 'Darwin' ? '' : 'nohup') : ''),
            '{windowsRun}' => $this->isWindows() ? 'start' : '',
            '{windowsBackground}' => $this->isWindows() ? ($this->runInBackground ? '/B' : '') : '',
            '{php}' => str_replace('-cgi', '', $this->getPHPExecutable()),
            '{yii}' => str_replace('/', DIRECTORY_SEPARATOR, Yii::getAlias($this->yiiscript)),
            '{command}' => $cmd,
            '{dump}' => $this->isWindows() ? $this->windowsDump : ($this->useDevNull ? '> /dev/null 2>&1' : $this->linuxDump),
            '{linuxBackground}' => $this->isWindows() ? '' : ($this->runInBackground ? '&' : ''),
        ]);

        return trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $this->template)));
    }

    /**
     * Replace template tokens
     * @param array $pairs the token to find and its replaced value as key value pairs
     */
    protected function replaceTemplateTokens($pairs)
    {
        foreach ($pairs as $token => $replace)
        {
            if (strpos($this->template, $token) !== false)
                $this->template = str_replace($token, $replace, $this->template);
        }
    }

    /**
     * If property $phpexec is set it will be used as php executable
     *
     * @return string path to php executable
     */
    protected function getPHPExecutable()
    {
        if($this->phpexec)
            return $this->phpexec;

        return strpos(PHP_SAPI, 'apache') !== false ? PHP_BINDIR . '/php' : PHP_BINARY;
    }

    /**
     * Check operating system.
     * Some possible values for PHP predefined constant PHP_OS:
     * `CYGWIN_NT-5.1`, `Darwin`, `FreeBSD`, `HP-UX`, `IRIX64`, `Linux`, `NetBSD`,
     * `OpenBSD`, `SunOS`, `Unix`, `WIN32`, `WINNT`, `Windows`
     *
     * @return boolean `true` if it's Windows OS.
     */
    protected function isWindows()
    {
        return PHP_OS == 'WINNT' || PHP_OS == 'WIN32' || PHP_OS == 'Windows';
    }
}
