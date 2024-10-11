<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Electron JS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Web To Desktop</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Input form -->
        <form action="{{ route('save.name') }}" method="POST">
            @csrf

            <!-- Main Window Settings -->
            <h3>Main Window</h3>
            <div class="mb-3">
                <label for="mainWidth" class="form-label">Main Window Width</label>
                <input type="number" class="form-control" id="mainWidth" name="mainWidth" required>
            </div>
            <div class="mb-3">
                <label for="mainHeight" class="form-label">Main Window Height</label>
                <input type="number" class="form-control" id="mainHeight" name="mainHeight" required>
            </div>

            <!-- Splash Window Settings -->
            <h3>Splash Window</h3>
            <div class="mb-3">
                <label for="splashWidth" class="form-label">Splash Window Width</label>
                <input type="number" class="form-control" id="splashWidth" name="splashWidth" required>
            </div>
            <div class="mb-3">
                <label for="splashHeight" class="form-label">Splash Window Height</label>
                <input type="number" class="form-control" id="splashHeight" name="splashHeight" required>
            </div>

            <!-- Theme Color in RGB -->
            <h3>Theme Color</h3>
            <div class="mb-3">
                <label for="themeRed" class="form-label">Red</label>
                <input type="number" class="form-control" id="themeRed" name="themeRed" required>
            </div>
            <div class="mb-3">
                <label for="themeGreen" class="form-label">Green</label>
                <input type="number" class="form-control" id="themeGreen" name="themeGreen" required>
            </div>
            <div class="mb-3">
                <label for="themeBlue" class="form-label">Blue</label>
                <input type="number" class="form-control" id="themeBlue" name="themeBlue" required>
            </div>

            <!-- Load URL -->
            <h3>Load URL</h3>
            <div class="mb-3">
                <label for="loadURL" class="form-label">Load URL</label>
                <input type="text" class="form-control" id="loadURL" name="loadURL" required>
            </div>

            <!-- Menu Settings -->
            <h3>Menu</h3>
            <div class="mb-3">
                <label for="customMenuCount" class="form-label">Number of Custom Menus</label>
                <input type="number" class="form-control" id="customMenuCount" name="customMenuCount" required>
            </div>

            <!-- Options for Reload and Exit Buttons -->
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="reloadButton" name="reloadButton" value="1">
                <label class="form-check-label" for="reloadButton">Include Reload Button</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="exitButton" name="exitButton" value="1">
                <label class="form-check-label" for="exitButton">Include Exit Button</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary mt-3">Generate JS File</button>
        </form>
    </div>
</body>
</html>
