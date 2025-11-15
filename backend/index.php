<?php

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/vendor/autoload.php';
require 'WebDriverManager.php';

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\WebDriverExpectedCondition;



function sendError($message) {
    echo json_encode([
        'success' => false,
        'error' => $message,
        'data' => null
    ]);
    exit;
}

function sendSuccess($data) {
    echo json_encode([
        'success' => true,
        'error' => null,
        'data' => $data
    ]);
    exit;
}

function extractNumbers($text) {
    return preg_replace('/[^0-9]/', '', $text);
}

$startTime = microtime(true);

$url = $_GET['url'] ?? '';

if (empty($url)) {
    sendError('URL parameter is required');
}

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    sendError('Invalid URL');
}

if (strpos($url, 'yandex.ru/maps') === false && strpos($url, 'yandex.com/maps') === false) {
    sendError('Only Yandex Maps URLs are supported');
}

try {
    $manager = WebDriverManager::getInstance();
    $manager->checkTimeout();
    $driver = $manager->getDriver();
    
    $driver->get($url);
    
    $driver->wait(8, 500)->until(
        WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector('body'))
    );
    
    $driver->executeScript('window.scrollTo(0, 500);');
    usleep(300000);
    
    $overallRating = '';
    $totalReviews = '';
    
    try {
        $ratingElement = $driver->findElement(WebDriverBy::cssSelector('.business-summary-rating-badge-view__rating-text'));
        $overallRating = $ratingElement->getText();
        
        $ratingParts = $driver->findElements(WebDriverBy::cssSelector('.business-summary-rating-badge-view__rating-text'));
        if (count($ratingParts) >= 3) {
            $overallRating = $ratingParts[0]->getText() . '.' . $ratingParts[2]->getText();
        }
    } catch (Exception $e) {
    }
    
    try {
        $reviewsCountElement = $driver->findElement(WebDriverBy::cssSelector('.business-rating-amount-view._summary'));
        $totalReviewsText = $reviewsCountElement->getText();
        $totalReviews = extractNumbers($totalReviewsText);
    } catch (Exception $e) {
    }
    
    $reviews = [];
    $reviewSelectors = [
        '.business-review-view',
        '.card-review-view'
    ];
    
    foreach ($reviewSelectors as $reviewSelector) {
        try {
            $reviewElements = $driver->findElements(WebDriverBy::cssSelector($reviewSelector));
            
            foreach ($reviewElements as $reviewElement) {
                try {
                    $reviewData = [
                        'author' => '',
                        'date' => '',
                        'rating' => 0,
                        'text' => ''
                    ];
                    
                    try {
                        $authorElement = $reviewElement->findElement(WebDriverBy::cssSelector('.business-review-view__author-name'));
                        $reviewData['author'] = trim($authorElement->getText());
                    } catch (Exception $e) {
                        try {
                            $authorElement = $reviewElement->findElement(WebDriverBy::cssSelector('[class*="author-name"]'));
                            $reviewData['author'] = trim($authorElement->getText());
                        } catch (Exception $e) {
                        }
                    }
                    
                    try {
                        $dateElement = $reviewElement->findElement(WebDriverBy::cssSelector('.business-review-view__date span'));
                        $reviewData['date'] = trim($dateElement->getText());
                    } catch (Exception $e) {
                    }
                    
                    try {
                        $fullStars = $reviewElement->findElements(WebDriverBy::cssSelector('.business-rating-badge-view__star._full'));
                        $reviewData['rating'] = count($fullStars);
                    } catch (Exception $e) {
                    }
                    
                    try {
                        $textElement = $reviewElement->findElement(WebDriverBy::cssSelector('.business-review-view__body'));
                        $reviewData['text'] = trim($textElement->getText());
                    } catch (Exception $e) {
                        try {
                            $textElement = $reviewElement->findElement(WebDriverBy::cssSelector('.spoiler-view__text'));
                            $reviewData['text'] = trim($textElement->getText());
                        } catch (Exception $e) {
                        }
                    }
                    
                    if (!empty($reviewData['author']) || !empty($reviewData['text'])) {
                        $reviews[] = $reviewData;
                    }
                    
                } catch (Exception $e) {
                    continue;
                }
            }
            
            if (!empty($reviews)) break;
            
        } catch (Exception $e) {
            continue;
        }
    }
    
    $executionTime = round(microtime(true) - $startTime, 2);
    
    $result = [
        'overall_rating' => $overallRating,
        'total_reviews' => $totalReviews,
        'reviews' => $reviews,
        'execution_time' => $executionTime
    ];
    
    sendSuccess($result);
    
} catch (Exception $e) {
    if (strpos($e->getMessage(), 'session') !== false) {
        WebDriverManager::getInstance()->restartDriver();
    }
    sendError('Parsing error: ' . $e->getMessage());
}