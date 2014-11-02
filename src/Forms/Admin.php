<?php

namespace Kpacha\Dynsatis\Forms;

use Symfony\Component\HttpFoundation\Request;

/**
 * Helper for the Admin form
 *
 * @author Kpacha <kpacha666@gmail.com>
 */
class Admin
{

    private static $paramNames = array(
        'name', 'homepage', 'allow_packagist', 'require_all', 'repos_vcs',
        'repos_composer', 'package_names', 'package_versions'
    );

    public function parse(Request $request)
    {
        foreach (self::$paramNames as $paramName) {
            $params[$paramName] = $request->request->get($paramName);
        }

        if (!$params['homepage']) {
            $params['homepage'] = 'http' . ($request->server->get('HTTPS') ? 's' : '') . '://' . $request->server->get('SERVER_NAME') . '/repo/' . $params['name'];
        }

        $packages = array();
        foreach ($params['package_names'] as $index => $packageName) {
            if (!$packageName) {
                continue;
            }
            $version = ($params['package_versions'][$index])? : '*';
            $packages[] = array('name' => $packageName, 'version' => $version);
        }
        unset($params['package_names'], $params['package_versions']);

        $params['packages'] = array_filter($packages);

        $params['repos_vcs'] = array_filter($params['repos_vcs']);
        $params['repos_composer'] = array_filter($params['repos_composer']);

        return $params;
    }

    public function prepare($storedConfig)
    {
        $config = array(
            'require' => array(),
            'repos_vcs' => array(),
            'repos_composer' => array(),
        );
        $config = array_merge($config, $storedConfig);

        $config['require_all'] = $config['require-all'];

        foreach ($config['repositories'] as $repo) {
            $config['repos_' . $repo['type']][] = $repo['url'];
        }
        unset($config['repositories']);
        return $config;
    }

}
