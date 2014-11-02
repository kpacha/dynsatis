<?php

namespace Kpacha\Dynsatis\Services;

/**
 * Repository service
 *
 * @author Kpacha <kpacha666@gmail.com>
 */
class Repository
{

    private $path;
    private $filesystem;
    private $finder;
    private $twig;

    public function __construct($path, $finder, $filesystem, $twig)
    {
        $this->path = $path;
        $this->finder = $finder;
        $this->filesystem = $filesystem;
        $this->twig = $twig;
    }

    public function getRepos()
    {
        $configFiles = $this->finder->files()->name('conf.json')->in($this->path)->depth('< 3');
        $repos = array();
        foreach ($configFiles as $configFile) {
            $repos[] = substr($configFile->getPath(), 1 + strlen($this->path));
        }
        return $repos;
    }

    public function getRepoConfig($repository)
    {
        $configFiles = $this->finder->files()->name('conf.json')->in($this->path . "/$repository");
        foreach ($configFiles as $configFile) {
            return json_decode($configFile->getContents(), true);
        }
        throw new \Exception('repo not found');
    }

    public function save($params, $repository = null)
    {
        $config = $this->twig->render('repo/config.json.twig', $params);

        if ($repository && $repository != $params['name']) {
            throw new \Exception('Inconsistent names');
        }

        if ($this->filesystem->exists($this->path . '/' . $params['name'])) {
            $this->filesystem->mkdir($this->path . '/' . $params['name']);
        }
        $this->filesystem->dumpFile(
                $this->path . '/' . $params['name'] . '/conf.json', $config, 0664
        );

        return true;
    }

    public function build($repository, $composerHome)
    {
        $configFile = escapeshellarg("web/repo/$repository/conf.json");
        $repoFolder = escapeshellarg("web/repo/$repository");
        $command = "cd .. && COMPOSER_HOME=$composerHome vendor/bin/satis build -vvv $configFile $repoFolder";
        $lastLine = exec($command, $output, $status);
        return array(
            'name' => $repository,
            'status' => $status,
            'output' => $output,
            'lastLine' => $lastLine
        );
        
    }

}
