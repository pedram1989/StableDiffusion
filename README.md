# Stable Diffusion Image Generator - AJAX & PHP Proxy

This project is a modern web interface for generating images using Stable Diffusion AI. It features AJAX-based functionality for seamless interaction and a PHP proxy for handling API requests and CORS issues. The user interface is designed to be sleek, user-friendly, and minimal, allowing users to generate and view images with ease.

## Features:
- **Generate Images**: Users can enter a text prompt and optionally add a negative prompt, adjust parameters like steps, CFG scale, resolution, and select a sampler.
- **HiRes Fix & Upscale**: Options to apply HiRes fix for better image quality and upscale the generated images.
- **Negative Prompt Suggestions**: Predefined negative prompts are available for quick selection.
- **History Management**: The history of generated images is stored, and users can view or clear their history.
- **Image Viewer**: Thumbnails of generated images are displayed. Clicking on an image opens it in a larger view with a download button.
- **Modern UI**: Dark-themed interface with smooth animations and an intuitive layout.

## How It Works:
- The front-end communicates with the back-end via AJAX requests.
- The back-end (PHP proxy) handles CORS issues and forwards requests to the local Stable Diffusion API.
- Image generation is processed, and the results are returned in base64 format, which is displayed in the UI.
- The generated images can be downloaded directly.

## Setup:
1. Clone this repository.
2. Ensure you have Stable Diffusion API running locally on your machine at `http://127.0.0.1:7860`.
3. Set up your PHP server with appropriate configurations to handle CORS and proxy requests.
4. Use the provided front-end (`index.html`) and back-end (`ajax.php` and `api_proxy.php`) files.

   ## How to Run:

### Prerequisites:
- **Stable Diffusion API**: You need to have the Stable Diffusion API running locally. This project assumes that the Stable Diffusion API is accessible at `http://127.0.0.1:7860`.
- **PHP Server**: Make sure your local PHP server is configured to handle requests and serve the files.
- **CORS Support**: Since we're using AJAX requests from the front-end, the PHP server should handle CORS issues (Cross-Origin Resource Sharing) properly.

### Steps to Run the Application:

1. **Clone the Repository**:
   Clone this repository to your local machine:
   ```bash
   git clone https://github.com/your-username/stable-diffusion-image-generator.git
   cd stable-diffusion-image-generator


## Usage:
1. Enter a **prompt** in the input field.
2. Optionally, add a **negative prompt** or select words from the predefined list.
3. Adjust the resolution and other settings as desired.
4. Press **Generate** to create images.
5. View generated images in the gallery and click to enlarge them.
6. Download images by clicking the download button.



Start the Stable Diffusion API: Ensure that you have the Stable Diffusion API running locally. You can run the API using the following command:


python stable-diffusion-webui/webui.py
By default, the API will run on http://127.0.0.1:7860.

- Set up PHP Server: You need a PHP server to act as a proxy between the front-end and the Stable Diffusion API.
- Make sure you have PHP installed on your system. If not, download and install it from php.net.
- Navigate to the project folder where the PHP files (ajax.php, api_proxy.php, etc.) are located.
- Start the PHP built-in server by running the following command in your terminal:


- php -S localhost:8080
- Open the Application in a Browser:

- Once the server is running, open your browser and navigate to:
- http://localhost:8080/index.html

You should now see the interface for generating images using Stable Diffusion.

Configurations (Optional):
1- If you want to modify the API endpoint or change other server settings, you can adjust the following:
2- In the api_proxy.php file, change the endpoint to your desired Stable Diffusion API location.
3- You can also change the ajax.php to adjust how the front-end interacts with the API (such as adding more parameters or customizing the request).

## Troubleshooting:
If you encounter any issues with CORS, make sure your PHP server is configured to handle CORS requests by including the necessary headers, like so:

- **header("Access-Control-Allow-Origin: *");**
- **header("Access-Control-Allow-Methods: POST, GET, OPTIONS");**
- **header("Access-Control-Allow-Headers: Content-Type");**
If the Stable Diffusion API is not working, make sure it is running correctly by accessing http://127.0.0.1:7860 in your browser.

If images are not being generated, check the network requests in your browser's developer tools for any errors.








## License:
This project is open-source and available under the MIT License.
