<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map Location</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            flex-direction: column;
            position: relative;
        }

        /* Back button positioning */
        .back-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-btn:hover {
            background-color: #45a049;
        }

        .map-container {
            text-align: center;
            margin-top: 40px;
        }

        iframe {
            border: 0;
            width: 600px;  /* Narrower map width */
            height: 450px; /* Fixed height */
        }
    </style>
</head>
<body>

    <!-- Back Button at the top right corner -->
    <a href="javascript:history.back()" class="back-btn">Back</a>

    <div class="map-container">
        <h2>Location: Patolot's Embroidery</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d16663.36534155246!2d120.90355932712555!3d13.879527222570982!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd0a211317fc85%3A0xf53cc1dd3b124224!2sPATOLOT&#39;S%20EMBROIDERY!5e1!3m2!1sen!2sph!4v1731873031531!5m2!1sen!2sph" width="600" height="450" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

</body>
</html>
