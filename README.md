📸 Stable Diffusion AJAX Image Generator (with PHP API Proxy)
This project provides a modern, user-friendly web interface for generating AI images using Stable Diffusion WebUI API. It utilizes an AJAX-based frontend with real-time interaction and a CORS-safe PHP proxy backend to seamlessly communicate with the local API (http://127.0.0.1:7860).


🧠 Features
🔥 Real-time image generation via txt2img endpoint.

✅ Negative prompt assistant with selectable pre-defined bad keywords.

🎛️ Prompt controls: CFG scale, steps, resolution sliders, sampler selection.

🌟 Support for:

HiRes Fix (second-pass refinement)

Upscaling (via extra-single-image)

📜 Image history (saved on the server as JSON).

🖼️ Click on a generated image to view it in a large modal.

💾 Download button to save the generated image with one click.

🌙 Dark mode interface (if integrated).

💡 Easy to customize and expand.

💡 How It Works
Frontend (HTML + JS)
Uses pure JavaScript (AJAX) to send a prompt and settings to a PHP proxy.

Automatically reads the image response and renders it inside the UI.

Provides sliders for resolution, checkboxes for features like upscaling/hires-fix.

Negative prompt builder helps users avoid common image artifacts with just one click.

Backend (PHP)
Acts as a CORS proxy to forward requests from the frontend to the local Stable Diffusion API.

Handles:

/sdapi/v1/txt2img for image generation.

/sdapi/v1/extra-single-image for optional upscaling.

Stores image metadata and history into a JSON file (history.json) for reuse.

🛠 Requirements
Local installation of Stable Diffusion WebUI (AUTOMATIC1111)

PHP 7.x+ server (e.g., XAMPP, MAMP, or built-in server)

Web browser (Chrome, Firefox, etc.)
