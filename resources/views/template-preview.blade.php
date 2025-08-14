<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $template->name }} - Preview</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #000;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        .preview-container {
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(45deg, #1a1a1a, #2a2a2a);
        }
        
        .tv-frame {
            position: relative;
            width: {{ $isCardPreview ? '80%' : '95%' }};
            height: {{ $isCardPreview ? '60%' : '90%' }};
            max-width: {{ $isCardPreview ? '400px' : '1920px' }};
            max-height: {{ $isCardPreview ? '300px' : '1080px' }};
            background: #000;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            overflow: hidden;
            border: 3px solid #333;
        }
        
        .tv-screen {
            width: 100%;
            height: 100%;
            overflow: hidden;
            position: relative;
        }
        
        .template-content {
            width: 100%;
            height: 100%;
            transform-origin: top left;
            transform: scale({{ $isCardPreview ? '0.3' : '0.6' }});
            position: absolute;
            top: 0;
            left: 0;
        }
        
        /* Ensure the template maintains its original aspect ratio and styling */
        .template-content iframe,
        .template-content html,
        .template-content body {
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
        }
        
        /* TV Stand for larger previews */
        @media (min-width: 768px) {
            .tv-frame::after {
                content: '';
                position: absolute;
                bottom: -20px;
                left: 50%;
                transform: translateX(-50%);
                width: 60px;
                height: 20px;
                background: #333;
                border-radius: 0 0 8px 8px;
            }
        }
        
        /* Hide scrollbars */
        ::-webkit-scrollbar {
            display: none;
        }
        * {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        /* Ensure template content maintains aspect ratio */
        .template-content * {
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="preview-container">
        <div class="tv-frame">
            <div class="tv-screen">
                <div class="template-content">
                    {!! $htmlContent !!}
                </div>
            </div>
        </div>
    </div>
</body>
</html> 