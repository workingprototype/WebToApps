<?php

namespace App\Http\Controllers;

use App\Models\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class NameController extends Controller
{
    // Display form and list of names
    public function index()
    {
        $names = Name::all();
        return view('names.index', compact('names'));
    }

    // Store the input and generate JS file
    public function store(Request $request)
{
    $request->validate([
        'mainWidth' => 'required|integer',
        'mainHeight' => 'required|integer',
        'splashWidth' => 'required|integer',
        'splashHeight' => 'required|integer',
        'themeRed' => 'required|integer|min:0|max:255',
        'themeGreen' => 'required|integer|min:0|max:255',
        'themeBlue' => 'required|integer|min:0|max:255',
        'loadURL' => 'required|string',
        'icon' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048', // Icon upload validation
    ]);

    // Handle icon upload and conversion to PNG format
    if ($request->hasFile('icon')) {
      $icon = $request->file('icon');
      $iconPngPath  = public_path('icon.png'); // Save as icon.png in the public root directory
      $iconIcnsPath = public_path('icon.icns'); // Save as icon.icns in the public root directory

      // Get the image type and convert to PNG
      $this->convertImageToPng($icon->getPathname(), $iconPngPath);
      // Convert PNG to ICNS format
      $this->convertPngToIcns($iconPngPath, $iconIcnsPath);
  }
  
    // Custom menu processing
    $customMenus = [];
    if ($request->has('menuName') && $request->has('menuLink')) {
        $menuNames = $request->menuName;
        $menuLinks = $request->menuLink;

        foreach ($menuNames as $index => $menuName) {
            $customMenus[] = [
                'label' => $menuName,
                'submenu' => [
                    [
                        'label' => 'Open ' . $menuName,
                        'click' => '() => { require("electron").shell.openExternal("' . $menuLinks[$index] . '"); }'
                    ]
                ]
            ];
        }
    }

    // Include Reload and Exit buttons if requested
    if ($request->has('reloadButton')) {
        $customMenus[] = [
            'label' => 'Reload',
            'click' => '() => { mainWindow.reload(); }',
        ];
    }
    if ($request->has('exitButton')) {
        $customMenus[] = [
            'label' => 'Exit',
            'click' => '() => { app.quit(); }',
        ];
    }

    // Build the JS file content
    $jsContent = "
    const { app, BrowserWindow, Menu, net } = require('electron');
    let mainWindow;
    let splash;

    const themeColor = { red: {$request->themeRed}, green: {$request->themeGreen}, blue: {$request->themeBlue} };

    function createWindow() {
      mainWindow = new BrowserWindow({
        width: {$request->mainWidth},
        height: {$request->mainHeight},
        show: false,
        icon: __dirname + '/icon.png',
        backgroundColor: `rgb(\${themeColor.red}, \${themeColor.green}, \${themeColor.blue})`,
        webPreferences: {
          nodeIntegration: true,
        },
      });

      splash = new BrowserWindow({
        width: {$request->splashWidth},
        height: {$request->splashHeight},
        frame: false,
        alwaysOnTop: true,
        transparent: true,
      });

      splash.loadFile('preload.html');

      checkOnlineStatus();

      const customMenu = Menu.buildFromTemplate(" . json_encode($customMenus, JSON_PRETTY_PRINT) . ");

      Menu.setApplicationMenu(customMenu);
    }

    function checkOnlineStatus() {
  const onlineStatus = net.isOnline();
  if (onlineStatus) {
    mainWindow.loadURL('{$request->loadURL}');
  } else {
    mainWindow.loadFile('offline.html');
  }

 // Handle transition when the main content has finished loading
  mainWindow.webContents.on('did-finish-load', () => {
    if (splash && !splash.isDestroyed()) { // Ensure splash window exists
      setTimeout(() => {
        splash.fadeOut(); // Custom fade-out function for the splash screen
        mainWindow.show(); // Show the main window after splash fades out
      }, 1000); // Optional delay for a smoother transition
    }
  });
}

// Fade-out method for splash screen
BrowserWindow.prototype.fadeOut = function() {
    if (!this.isDestroyed()) { // Ensure the window is not destroyed
      this.webContents.executeJavaScript(`
        document.body.style.transition = 'opacity 0.5s ease';
        document.body.style.opacity = 0;
      `).then(() => {
        setTimeout(() => {
          if (!this.isDestroyed()) {
            this.destroy(); // Destroy splash after fade-out completes
          }
        }, 50); // Ensure splash is destroyed only after fade-out
      });
    }
  };

// Function to reload when reconnect button is clicked
function reconnect() {
  if (mainWindow && !mainWindow.isDestroyed()) {
    mainWindow.reload(); // Reload the main window
  }
}

// Listen to the reconnect event from offline.html (use IPC for communication)
app.whenReady().then(() => {
  createWindow();

  const { ipcMain } = require('electron');
  ipcMain.on('reconnect', (event) => {
    reconnect();
  });
});

app.on('window-all-closed', () => {
  if (process.platform !== 'darwin') app.quit();
});

app.on('activate', () => {
  if (BrowserWindow.getAllWindows().length === 0) createWindow();
});
    ";

    $fileName = 'electronConfig.js';
    $headers = [
        'Content-type' => 'application/javascript',
        'Content-Disposition' => 'attachment; filename=' . $fileName,
    ];

    return response()->make($jsContent, 200, $headers);
}
private function convertImageToPng($sourcePath, $destinationPath)
{
    // Create a GD image resource from the source file
    $sourceImage = null;
    $imageInfo = getimagesize($sourcePath);
    $mimeType = $imageInfo['mime'];

    switch ($mimeType) {
        case 'image/jpeg':
        case 'image/jpg':
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case 'image/png':
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        case 'image/gif':
            $sourceImage = imagecreatefromgif($sourcePath);
            break;
        case 'image/svg+xml':
            // SVG conversion to PNG would need additional steps (SVG to raster conversion)
            // Here we can skip or handle as needed
            break;
        default:
            // Handle unsupported formats or skip
            break;
    }

    if ($sourceImage) {
        // Save the image as PNG to the destination path
        imagepng($sourceImage, $destinationPath);

        // Free the memory
        imagedestroy($sourceImage);
    }
}

private function convertPngToIcns($pngPath, $icnsPath)
{
    // Use the exec function to call ImageMagick for conversion
    exec("convert " . escapeshellarg($pngPath) . " " . escapeshellarg($icnsPath));
}

public function exportJson(Request $request)
{
    $request->validate([
        'appName' => 'required|string',
        'appVersion' => 'required|string',
        'appDescription' => 'required|string',
        'appID' => 'required|string',
        'productName' => 'required|string',
    ]);

    // Prepare the JSON content
    $jsonData = [
        'name' => $request->appName,
        'version' => $request->appVersion,
        'description' => $request->appDescription,
        'main' => 'main.js',
        'scripts' => [
            'pack' => 'electron-builder --dir',
            'dist' => 'electron-builder',
        ],
        'keywords' => [],
        'author' => '',
        'license' => 'ISC',
        'devDependencies' => [
            'electron' => '^32.1.2',
            'electron-builder' => '^25.1.7',
            'electron-packager' => '^15.5.2',
        ],
        'build' => [
            'appId' => $request->appID,
            'productName' => $request->productName,
            'mac' => [
                'icon' => 'icon.icns',
                'target' => ['dmg', 'zip'],
            ],
            'win' => [
                'icon' => 'icon.ico',
                'target' => ['nsis', 'zip'],
            ],
            'linux' => [
                'icon' => 'icon.png',
                'target' => 'AppImage',
            ],
        ],
    ];

    $fileName = 'electronConfig.json';
    $headers = [
        'Content-type' => 'application/json',
        'Content-Disposition' => 'attachment; filename=' . $fileName,
    ];

    return response()->json($jsonData, 200, $headers);
}


}
