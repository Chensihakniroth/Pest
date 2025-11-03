<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page</title>
    <style>
        * {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            outline: none !important;
        }
        
        input, textarea, select {
            -webkit-user-select: text;
            -moz-user-select: text;
            -ms-user-select: text;
            user-select: text;
        }
        
        body {
            cursor: default;
            margin: 20px;
        }
    </style>
</head>
<body>
    <h1>Test Page - No External CSS/JS</h1>
    <p>Click around this page. Is the blinking cursor still there?</p>
    <button>Test Button</button>
    <input type="text" placeholder="This input should show cursor">
</body>
</html>