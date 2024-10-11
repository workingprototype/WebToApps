<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebToApp Builder</title>
    <!-- Bootstrap CSS, JS and dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .custom-menu {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">WebToApp Builder</div>

                    <div class="card-body">
                    <form action="{{ route('names.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="mainWidth">Main Window Width</label>
                                <input type="number" class="form-control" id="mainWidth" name="mainWidth" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="mainHeight">Main Window Height</label>
                                <input type="number" class="form-control" id="mainHeight" name="mainHeight" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="splashWidth">Splash Window Width</label>
                                <input type="number" class="form-control" id="splashWidth" name="splashWidth" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="splashHeight">Splash Window Height</label>
                                <input type="number" class="form-control" id="splashHeight" name="splashHeight" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="themeColor">Theme Color (RGB)</label>
                                <div class="d-flex">
                                    <input type="number" class="form-control me-2" placeholder="Red" name="themeRed" min="0" max="255" required>
                                    <input type="number" class="form-control me-2" placeholder="Green" name="themeGreen" min="0" max="255" required>
                                    <input type="number" class="form-control" placeholder="Blue" name="themeBlue" min="0" max="255" required>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="loadURL">Load URL</label>
                                <input type="text" class="form-control" id="loadURL" name="loadURL" required>
                            </div>

                            <div class="form-group mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="reloadButton" name="reloadButton">
                                <label class="form-check-label" for="reloadButton">Include Reload Button?</label>
                            </div>

                            <div class="form-group mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="exitButton" name="exitButton">
                                <label class="form-check-label" for="exitButton">Include Exit Button?</label>
                            </div>

                            <div id="custom-menus" class="mb-3">
                                <label>Custom Menus</label>
                                <!-- Dynamic custom menu fields will be inserted here -->
                            </div>

                            <button type="button" id="add-menu" class="btn btn-secondary mb-3">Create a Custom Menu</button>

                            <!-- Icon upload -->
    <div class="form-group mb-3">
        <label for="icon">Upload Icon (PNG, JPG, JPEG, SVG)</label>
        <input type="file" class="form-control" id="icon" name="icon" required>
    </div>

                            <button type="submit" class="btn btn-primary">Generate JS</button>
                        </form>
                        <form action="{{ route('names.exportJson') }}" method="POST">
        @csrf
        <h2>App Details</h2>
        <label for="appName">App Name</label>
        <input type="text" name="appName" required>

        <label for="appVersion">App Version</label>
        <input type="text" name="appVersion" required>

        <label for="appDescription">App Description</label>
        <input type="text" name="appDescription" required>

        <label for="appID">App ID</label>
        <input type="text" name="appID" required>

        <label for="productName">Product Name</label>
        <input type="text" name="productName" required>

        <button type="submit">Export JSON</button>
    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-menu').addEventListener('click', function() {
            const customMenusDiv = document.getElementById('custom-menus');
            const menuIndex = customMenusDiv.children.length / 2;
            const newMenu = `
                <div class="form-group mb-3">
                    <label for="menuName${menuIndex}">Menu Name</label>
                    <input type="text" class="form-control" id="menuName${menuIndex}" name="menuName[]">
                </div>
                <div class="form-group mb-3">
                    <label for="menuLink${menuIndex}">Menu Link</label>
                    <input type="text" class="form-control" id="menuLink${menuIndex}" name="menuLink[]">
                </div>
                <button type="button" class="btn btn-danger btn-sm mb-3 remove-menu">Delete Menu</button>
            `;
            customMenusDiv.insertAdjacentHTML('beforeend', newMenu);

            // Add event listener to the newly created "Delete Menu" button
            const deleteButtons = document.querySelectorAll('.remove-menu');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.previousElementSibling.remove(); // Remove the menu link input
                    this.previousElementSibling.remove(); // Remove the menu name input
                    this.remove(); // Remove the delete button itself
                });
            });
        });
    </script>
</body>
</html>
