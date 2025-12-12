<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class StripBasePath implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Get the current path from the request
        $path = $request->getPath();
        
        // Get URI object to check routePath
        $reflection = new \ReflectionClass($request);
        $uri = null;
        if ($reflection->hasProperty('uri')) {
            $property = $reflection->getProperty('uri');
            $property->setAccessible(true);
            $uri = $property->getValue($request);
        }
        
        // Check URI's routePath if it contains subdirectory
        if ($uri instanceof \CodeIgniter\HTTP\SiteURI) {
            $routePath = $uri->getRoutePath();
            // If routePath contains subdirectory, we need to strip it
            if (str_contains($routePath, 'ITE311-BUHISAN/public')) {
                $path = '/' . $routePath;
            }
        }
        
        // Get base path from baseURL
        $baseURL = config('App')->baseURL;
        $basePath = parse_url($baseURL, PHP_URL_PATH);
        $basePath = trim($basePath, '/');
        
        // Common subdirectory patterns to strip
        $subdirectoryPatterns = [
            'ITE311-BUHISAN/public',
        ];
        
        // Normalize path
        $pathTrimmed = trim($path, '/');
        $stripped = false;
        $newPath = $path;
        
        // First, try to strip baseURL path
        if (!empty($basePath) && !empty($path)) {
            $basePathTrimmed = trim($basePath, '/');
            
            // Check if path starts with base path
            if (str_starts_with($pathTrimmed, $basePathTrimmed)) {
                // Remove base path from the beginning
                $newPath = substr($pathTrimmed, strlen($basePathTrimmed));
                $newPath = trim($newPath, '/');
                $newPath = $newPath === '' ? '/' : '/' . $newPath;
                $stripped = true;
            }
        }
        
        // If not stripped yet, try subdirectory patterns
        if (!$stripped) {
            foreach ($subdirectoryPatterns as $pattern) {
                $patternTrimmed = trim($pattern, '/');
                if (str_starts_with($pathTrimmed, $patternTrimmed)) {
                    // Remove subdirectory pattern from the beginning
                    $newPath = substr($pathTrimmed, strlen($patternTrimmed));
                    $newPath = trim($newPath, '/');
                    $newPath = $newPath === '' ? '/' : '/' . $newPath;
                    $stripped = true;
                    break;
                }
            }
        }
        
        // Only update if we actually stripped something
        if ($stripped && $newPath !== $path) {
            $this->updateRequestPath($request, $newPath);
        }
        
        return $request;
    }
    
    private function updateRequestPath($request, $newPath)
    {
        // Use reflection to modify the request
        $reflection = new \ReflectionClass($request);
        
        // Update the path property directly
        if ($reflection->hasProperty('path')) {
            $property = $reflection->getProperty('path');
            $property->setAccessible(true);
            $property->setValue($request, $newPath);
        }
        
        // Update the URI object's route path - this is critical for routing
        if ($reflection->hasProperty('uri')) {
            $property = $reflection->getProperty('uri');
            $property->setAccessible(true);
            $uri = $property->getValue($request);
            
            // For SiteURI, we need to update the routePath property directly
            if ($uri instanceof \CodeIgniter\HTTP\SiteURI) {
                $uriReflection = new \ReflectionClass($uri);
                
                // Update routePath property
                if ($uriReflection->hasProperty('routePath')) {
                    $routePathProperty = $uriReflection->getProperty('routePath');
                    $routePathProperty->setAccessible(true);
                    $routePath = ltrim($newPath, '/');
                    $routePathProperty->setValue($uri, $routePath);
                }
                
                // Update segments property
                if ($uriReflection->hasProperty('segments')) {
                    $segmentsProperty = $uriReflection->getProperty('segments');
                    $segmentsProperty->setAccessible(true);
                    $routePath = ltrim($newPath, '/');
                    $segments = $routePath === '' ? [] : explode('/', $routePath);
                    $segmentsProperty->setValue($uri, $segments);
                }
            } elseif (method_exists($uri, 'setRoutePath')) {
                $routePath = ltrim($newPath, '/');
                $uri->setRoutePath($routePath);
            } elseif (method_exists($uri, 'setPath')) {
                $uri->setPath($newPath);
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
