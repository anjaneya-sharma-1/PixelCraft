// Get the source image to be edited
let image = document.getElementById('sourceImage');
let texts = []; // Array to store added text boxes
let activeText = null;
// Get the canvas for the edited image
let canvas = document.getElementById('canvas');
let context = canvas.getContext('2d');

// Get all the sliders of the image
let brightnessSlider = document.getElementById("brightnessSlider");
let contrastSlider = document.getElementById("contrastSlider");
let grayscaleSlider = document.getElementById("grayscaleSlider");
let hueRotateSlider = document.getElementById("hueRotateSlider");
let saturateSlider = document.getElementById("saturationSlider");
let sepiaSlider = document.getElementById("sepiaSlider");
class Textbox {
    constructor(text, x, y, fontSize = 60, font = 'Arial') {
        this.text = text;
        this.x = x;
        this.y = y;
        this.fontSize = fontSize;
        this.font = font;
        this.isDragging = false;
        this.isResizing = false;
    }

    // Check if a point (mouse position) is within the text bounds
    contains(x, y) {
        const textWidth = context.measureText(this.text).width;
        return (x >= this.x && x <= this.x + textWidth && y >= this.y - this.fontSize && y <= this.y);
    }

    // Check if the point is near the resize handle (bottom-right corner)
    isNearResizeHandle(x, y) {
        const textWidth = context.measureText(this.text).width;
        const resizeZone = textWidth * 0.2; // Resize zone near the bottom-right corner
        return (
            x >= this.x + textWidth - resizeZone &&
            x <= this.x + textWidth  &&
            y >= this.y - this.fontSize - resizeZone &&
            y <= this.y + resizeZone
        );
    }

    // Draw the text onto the canvas
    draw(ctx) {
        ctx.font = `${this.fontSize}px ${this.font}`;
        ctx.fillText(this.text, this.x, this.y);

        // Draw resize handle
        ctx.strokeStyle = 'blue';
        ctx.strokeRect(this.x + ctx.measureText(this.text).width - 10, this.y - this.fontSize, 10, 10);
    }
}

// Function for uploading the image from the file system

function loadImage() {
    
    image.onload = function () {

        // Set canvas dimensions to the image's dimensions
        canvas.width = this.width;
        canvas.height = this.height;
        document.getElementById('uploadSection').style.display = 'none';
        document.getElementById('editorSection').style.display = 'block';
        applyFilter();
        document.getElementById('sourceImage').style.display = 'block';
    document.querySelector('.image-controls').style.display = 'block';
    document.querySelector('.image-save').style.display = 'flex'; // Flex for alignment
    document.querySelector('.text-controls').style.display = 'block';
    document.querySelector('.clipart-controls').style.display = 'block';
    document.querySelector('.preset-filters').style.display = 'block';
            // Show controls and hide help text
        document.querySelector('.help-text').style.display = "none";
        document.querySelector('.image-save').style.display = "block";
        document.querySelector('.image-controls').style.display = "block";
        document.querySelector('.preset-filters').style.display = "block";
        document.querySelector('.clipart-controls').style.display="block";
    };
    const img = document.getElementById("sourceImage");
    const canvas = document.getElementById("canvas");
    const ctx = canvas.getContext("2d");

    img.onload = () => {
        canvas.width = img.width;
        canvas.height = img.height;
        ctx.drawImage(img, 0, 0);
    };
    img.src = img.src; // Trigger loading
}
// Function to apply the filters to the image
function applyFilter() {
    let filterString =
        "brightness(" + brightnessSlider.value + "%" +
        ") contrast(" + contrastSlider.value + "%" +
        ") grayscale(" + grayscaleSlider.value + "%" +
        ") saturate(" + saturateSlider.value + "%" +
        ") sepia(" + sepiaSlider.value + "%" +
        ") hue-rotate(" + hueRotateSlider.value + "deg" + ")";

    context.clearRect(0, 0, canvas.width, canvas.height);
    context.filter = filterString;
    context.drawImage(image, 0, 0, canvas.width, canvas.height);
    drawCanvas(); // Redraw the cliparts
}

// Preset Filter Functions
function brightenFilter() {
    resetImage();
    brightnessSlider.value = 130;
    contrastSlider.value = 120;
    saturateSlider.value = 120;
    applyFilter();
}

function bwFilter() {
    resetImage();
    grayscaleSlider.value = 100;
    brightnessSlider.value = 120;
    contrastSlider.value = 120;
    applyFilter();
}

function funkyFilter() {
    resetImage();
    hueRotateSlider.value = Math.floor(Math.random() * 360) + 1;
    contrastSlider.value = 120;
    applyFilter();
}

function vintageFilter() {
    resetImage();
    brightnessSlider.value = 120;
    saturateSlider.value = 120;
    sepiaSlider.value = 150;
    applyFilter();
}

// Reset Image Filters
function resetImage() {
    brightnessSlider.value = 100;
    contrastSlider.value = 100;
    grayscaleSlider.value = 0;
    hueRotateSlider.value = 0;
    saturateSlider.value = 100;
    sepiaSlider.value = 0;
    applyFilter();
}

// Clipart Management
let isAddingClipart = false;
let selectedClipart = "";
let cliparts = []; // Array to store added cliparts with position and size
let activeClipart = null; // Store the currently active (selected) clipart
let isResizing = false; // Track whether the user is resizing

// Clipart object constructor to store position and size
class Clipart {
    constructor(image, x, y, width, height) {
        this.image = image;
        this.x = x;
        this.y = y;
        this.width = width;
        this.height = height;
        this.isDragging = false;
    }

    // Check if a point (mouse position) is within the clipart bounds
    contains(x, y) {
        return (x >= this.x && x <= this.x + this.width && y >= this.y && y <= this.y + this.height);
    }

    // Check if the point is near the resize handle (bottom-right corner)
    isNearResizeHandle(x, y) {
        const resizeZone = this.width * 0.2; // Resize zone is a small area on the bottom-right corner
        return 0;
    }

    // Draw the clipart onto the canvas
    draw(ctx) {
        ctx.drawImage(this.image, this.x, this.y, this.width, this.height);
        // Draw resize handle
        ctx.strokeStyle = 'red';
        ctx.strokeRect(this.x + this.width * 0.8, this.y + this.height - this.width * 0.2, this.width * 0.2, this.width * 0.2);
    }
}

// Function to add clipart to the canvas
function addClipartMode(event) {
    selectedClipart = URL.createObjectURL(event.target.files[0]);

    isAddingClipart = true;
    canvas.style.cursor = 'crosshair'; // Change cursor to crosshair for placement


}

// Function to handle canvas click for placing or selecting clipart
canvas.addEventListener('mousedown', function (event) {
    let rect = canvas.getBoundingClientRect();
    const x = (event.clientX - rect.left) / (rect.right - rect.left) * canvas.width;
    const y = (event.clientY - rect.top) / (rect.bottom - rect.top) * canvas.height;

    if (isAddingClipart && selectedClipart) {
        // If in add mode, place new clipart
        let clipartImage = new Image();
        clipartImage.src = `${selectedClipart}`;

        clipartImage.onload = function () {
            const clipart = new Clipart(clipartImage, x, y, 1000, 1000); // Default clipart size
            cliparts.push(clipart);
            saveState(); // Save the state for undo/redo
            drawCanvas();
        };

        isAddingClipart = false;
        canvas.style.cursor = 'default';
    } else {
        // Check if we clicked on any existing clipart to drag/resize
        activeClipart = null;
        isResizing = false;
        activeText = null;
    for (let textbox of texts) {
        if (textbox.isNearResizeHandle(x, y)) {
            activeText = textbox;
            textbox.isResizing = true;
            break;
        } else if (textbox.contains(x, y)) {
            activeText = textbox;
            textbox.isDragging = true;
            break;
        }
    }
        for (let clipart of cliparts) {
            if (clipart.isNearResizeHandle(x, y)) {
                activeClipart = clipart;
                isResizing = true;
                break;
            } else if (clipart.contains(x, y)) {
                activeClipart = clipart;
                activeClipart.isDragging = true;
                break;
            }
        }
    }
});

// Function to handle dragging and resizing
canvas.addEventListener('mousemove', function (event) {
    let rect = canvas.getBoundingClientRect();
    const x = (event.clientX - rect.left) / (rect.right - rect.left) * canvas.width;
    const y = (event.clientY - rect.top) / (rect.bottom - rect.top) * canvas.height;


    if (activeText && activeText.isDragging) {
        activeText.x = x;
        activeText.y = y;
        drawCanvas();
    } else if (activeText && activeText.isResizing) {
        const newSize = Math.max(10, (y - activeText.y) + activeText.fontSize);
        activeText.fontSize = newSize;
        drawCanvas();
    }

    if (activeClipart && activeClipart.isDragging && !isResizing) {
        // Dragging the clipart
        activeClipart.x = x - activeClipart.width / 2;
        activeClipart.y = y - activeClipart.height / 2;
        drawCanvas();
    } else if (activeClipart && isResizing) {
        // Resizing the clipart
        activeClipart.width = x - activeClipart.x;
        activeClipart.height = y - activeClipart.y;
        drawCanvas();
    }
});

// Stop dragging/resizing on mouse up
canvas.addEventListener('mouseup', function () {
    if (activeClipart) {
        activeClipart.isDragging = false;
        isResizing = false;
        activeClipart = null;
        saveState(); // Save the final state after moving/resizing
    }
    if (activeText) {
        activeText.isDragging = false;
        activeText.isResizing = false;
        saveState(); // Save the final state after moving/resizing
        activeText = null;
    }
});
function addText() {
    const text = document.getElementById('textInput').value;
    const font = document.getElementById('fontSelect').value;

    if (text) {
        const textbox = new Textbox(text, 50, 50, 100, font);
        texts.push(textbox);
        saveState(); // Save the state for undo/redo
        drawCanvas();
    }
}

// Draw all elements on the canvas
function drawCanvas() {
    // Clear the canvas
    context.clearRect(0, 0, canvas.width, canvas.height);

    // Redraw the image and the cliparts
    context.drawImage(image, 0, 0, canvas.width, canvas.height);
    for (let clipart of cliparts) {
        clipart.draw(context);
    }
    for (let textbox of texts) {
        textbox.draw(context);
    }
}

// Undo/Redo feature (save state for canvas actions)
let undoStack = [];
let redoStack = [];

function saveState() {
    undoStack.push(canvas.toDataURL());
    redoStack = [];
}

function undo() {
    if (undoStack.length > 0) {
        redoStack.push(undoStack.pop());
        let img = new Image();
        img.src = undoStack[undoStack.length - 1];
        img.onload = () => context.drawImage(img, 0, 0, canvas.width, canvas.height);
    }
}

function redo() {
    if (redoStack.length > 0) {
        let img = new Image();
        img.src = redoStack.pop();
        img.onload = () => context.drawImage(img, 0, 0, canvas.width, canvas.height);
        saveState();
    }
}

// Save Edited Image

document.addEventListener('DOMContentLoaded', function () {
 
    loadImage();
});