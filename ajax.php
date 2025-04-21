<?php
session_start();

// Allow CORS from any origin
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$history_file = __DIR__ . '/history.json';
$history = file_exists($history_file) ? json_decode(file_get_contents($history_file), true) : [];

$input = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($input['action']) && $input['action'] === 'delete_history') {
        unlink($history_file);
        echo json_encode(["status" => "success", "message" => "History cleared."]);
        exit;
    }

    $prompt = trim($input['prompt'] ?? '');
    $neg_prompt = trim($input['neg_prompt'] ?? '');
    $steps = (int)($input['steps'] ?? 30);
    $cfg = (float)($input['cfg'] ?? 7.5);
    $width = (int)($input['width'] ?? 512);
    $height = (int)($input['height'] ?? 512);
    $num_images = (int)($input['num_images'] ?? 1);
    $sampler = $input['sampler'] ?? 'Euler';
    $upscale = !empty($input['upscale']);
    $hires_fix = !empty($input['hires_fix']);

    $data = [
        "prompt" => $prompt,
        "negative_prompt" => $neg_prompt,
        "steps" => $steps,
        "cfg_scale" => $cfg,
        "width" => $width,
        "height" => $height,
        "sampler_name" => $sampler,
        "n_iter" => 1,
        "batch_size" => $num_images
    ];

    if ($hires_fix) {
        $data["enable_hr"] = true;
        $data["hr_scale"] = 2;
        $data["hr_upscaler"] = "Latent";
        $data["hr_second_pass_steps"] = $steps;
    }

    $ch = curl_init("http://127.0.0.1:7860/sdapi/v1/txt2img");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        echo json_encode(["status" => "error", "message" => "Curl error: $error"]);
        exit;
    }

    $result = json_decode($response, true);

    if (isset($result['images'])) {
        $images = [];
        foreach ($result['images'] as $base64) {
            $images[] = 'data:image/png;base64,' . $base64;
        }

        $entry = [
            'time' => date('Y-m-d H:i:s'),
            'prompt' => $prompt,
            'neg_prompt' => $neg_prompt,
            'params' => [
                'steps' => $steps,
                'cfg' => $cfg,
                'width' => $width,
                'height' => $height,
                'sampler' => $sampler,
                'count' => $num_images,
                'hires_fix' => $hires_fix,
                'upscale' => $upscale,
            ],
            'images' => $images
        ];

        $history[] = $entry;
        file_put_contents($history_file, json_encode($history, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        if ($upscale) {
            $upscaled = [];
            foreach ($result['images'] as $base64) {
                $upscale_data = [
                    "image" => $base64,
                    "upscaler_1" => "Latent",
                    "resize_mode" => 0,
                    "upscale" => 2
                ];
                $ch = curl_init("http://127.0.0.1:7860/sdapi/v1/extra-single-image");
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($upscale_data),
                    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                ]);
                $up_response = curl_exec($ch);
                curl_close($ch);
                $up_result = json_decode($up_response, true);
                if (isset($up_result['image'])) {
                    $upscaled[] = 'data:image/png;base64,' . $up_result['image'];
                }
            }
            echo json_encode(["status" => "success", "images" => $upscaled]);
        } else {
            echo json_encode(["status" => "success", "images" => $images]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid response from API"]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(["status" => "success", "history" => $history]);
    exit;
} else {
    echo json_encode(["status" => "error", "message" => "Unsupported request method"]);
    exit;
}
