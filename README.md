# Laravel 9 Crop Image Before Upload using Cropper JS
Laravel 9 crop image before upload exmaple; Through this tutorial, i am going to show you how to crop image before upload using cropper js in laravel 9 apps. And as well as, you will learn how to crop and resize image before upload to sever without refreshing or reloading the whole web page using cropper js, ajax and bootstrap model in laravel 9 apps.

<p align="center"><a href="https://wesley.io.ke" target="_blank"><img src="https://laratutorials.com/wp-content/uploads/2022/02/Laravel-9-Crop-Image-Before-Upload-using-Cropper-JS-1024x499.jpg" width="400"></a></p>

A simple jQuery image cropping plugin. As of v4.0.0, the core code of Cropper is replaced with Cropper.js. I recommend you to use the jquery-cropper instead of Cropper.

# Laravel 9 Crop Image Before Upload using Cropper JS
Use the below given steps to integrate copper js for crop image before upload in laravel 9 apps:
|#|Action|
|---|---|
|Step 1 | Installing Laravel 9 Application|
|Step 2 | Configuring Database Details|
|Step 3 | Creating Model & Migration|
|Step 4 | Create Routes|
|Step 5 | Creating Crop Image Upload Controller|
|Step 6 | Creating Crop Image Upload Blade View|
|Step 7 | Import Cropper Library and Implementing Ajax Code|
|Step 8 |Start Development Server|

# Step 1 – Installing Laravel 9 Application
Execute the following command on terminal to install laravel 9 apps:

```php
composer create-project --prefer-dist laravel/laravel demo
```
# Step 2 – Configuring Database Details
Open your downloaded laravel app into any text editor. Then find .env file and configure database detail like following:
```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db name
DB_USERNAME=db user name
DB_PASSWORD=db password
```
# Step 3 – Creating Model & Migration
Execute the following command on terminal to navigate to your project by using the following command:
```php
cd / demo
```
Then create model and migration file by using the following command:

```php
php artisan make:model Picture -m
```
The above command will create two files into your laravel image upload tutorial app, which is located inside the following locations:

/app/Models/picture.php
/database/migrations/create_pictures_table.php
So, find create_pictures_table.php file inside /database/migrations/ directory. Then open this file and add the following code into function up() on this file:
```php
    public function up()
    {
        Schema::create('pictures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->timestamps();
        });
    }
    ```
Now, open again your terminal and type the following command on cmd to create tables into your selected database:

```php
php artisan migrate
```
# Step 4 – Create Routes
Open your web.php file, which is located inside routes directory. Then add the following routes into web.php file:
```php
use App\Http\Controllers\CropImageController;
Route::get('crop-image-upload', [CropImageController::class, 'index']);
Route::post('crop-image-upload', [CropImageController::class, 'uploadCropImage']);
```
# Step 5 – Creating Crop Image Upload Controller
Create crop image upload controller by using the following command:
```php
php artisan make:controller CropImageController
```
The above command will create CropImageController.php file, which is located inside /app/Http/Controllers/ directory.
```php
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Picture;
class CropImageController extends Controller
{
    public function index()
    {
        return view('crop-image-upload');
    }
    public function uploadCropImage(Request $request)
    {
        $folderPath = public_path('upload/');
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $imageName = uniqid() . '.png';
        $imageFullPath = $folderPath.$imageName;
        file_put_contents($imageFullPath, $image_base64);
         $saveFile = new Picture;
         $saveFile->name = $imageName;
         $saveFile->save();
   
        return response()->json(['success'=>'Crop Image Uploaded Successfully']);
    }
}
```
# Step 6 – Creating Crop Image Upload Blade View
Ceate new blade view file that named crop-image-upload.blade.php inside resources/views directory and add the following code into it:
```php

<!DOCTYPE html>
<html>
<head>
    <title>Laravel 9 Crop Image Before Upload using Cropper js - laratutorials.com</title>
    <meta name="_token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
</head>
<style type="text/css">
img {
  display: block;
  max-width: 100%;
}
.preview {
  overflow: hidden;
  width: 160px; 
  height: 160px;
  margin: 10px;
  border: 1px solid red;
}
.modal-lg{
  max-width: 1000px !important;
}
</style>
<body>
  
<div class="container mt-5">
  <div class="card">
    <h2 class="card-header">Laravel 9 Crop Image Before Upload - Wesley</h2>
    <div class="card-body">
      <h5 class="card-title">Please Selete Image For Cropping</h5>
      <input type="file" name="image" class="image">
    </div>
  </div>  
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Laravel Cropper Js - Crop Image Before Upload - Tutsmake.com</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-8">
                    <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                </div>
                <div class="col-md-4">
                    <div class="preview"></div>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="crop">Crop</button>
      </div>
    </div>
  </div>
</div>
<script>
var $modal = $('#modal');
var image = document.getElementById('image');
var cropper;
  
$("body").on("change", ".image", function(e){
    var files = e.target.files;
    var done = function (url) {
      image.src = url;
      $modal.modal('show');
    };
    var reader;
    var file;
    var url;
    if (files && files.length > 0) {
      file = files[0];
      if (URL) {
        done(URL.createObjectURL(file));
      } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function (e) {
          done(reader.result);
        };
        reader.readAsDataURL(file);
      }
    }
});
$modal.on('shown.bs.modal', function () {
    cropper = new Cropper(image, {
      aspectRatio: 1,
      viewMode: 3,
      preview: '.preview'
    });
}).on('hidden.bs.modal', function () {
   cropper.destroy();
   cropper = null;
});
$("#crop").click(function(){
    canvas = cropper.getCroppedCanvas({
        width: 160,
        height: 160,
      });
    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
         reader.readAsDataURL(blob); 
         reader.onloadend = function() {
            var base64data = reader.result; 
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "crop-image-upload",
                data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},
                success: function(data){
                    console.log(data);
                    $modal.modal('hide');
                    alert("Crop image successfully uploaded");
                }
              });
         }
    });
})
</script>
</body>
</html> 
```
# Step 7 – Import Cropper Library and Implementing Ajax Code
Import cropper js library and implement ajax code for upload image without refreshing whole web page. Then add the following code into your view file:
```php
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
<script>
var $modal = $('#modal');
var image = document.getElementById('image');
var cropper;
  
$("body").on("change", ".image", function(e){
    var files = e.target.files;
    var done = function (url) {
      image.src = url;
      $modal.modal('show');
    };
    var reader;
    var file;
    var url;
    if (files && files.length > 0) {
      file = files[0];
      if (URL) {
        done(URL.createObjectURL(file));
      } else if (FileReader) {
        reader = new FileReader();
        reader.onload = function (e) {
          done(reader.result);
        };
        reader.readAsDataURL(file);
      }
    }
});
$modal.on('shown.bs.modal', function () {
    cropper = new Cropper(image, {
      aspectRatio: 1,
      viewMode: 3,
      preview: '.preview'
    });
}).on('hidden.bs.modal', function () {
   cropper.destroy();
   cropper = null;
});
$("#crop").click(function(){
    canvas = cropper.getCroppedCanvas({
        width: 160,
        height: 160,
      });
    canvas.toBlob(function(blob) {
        url = URL.createObjectURL(blob);
        var reader = new FileReader();
         reader.readAsDataURL(blob); 
         reader.onloadend = function() {
            var base64data = reader.result; 
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "crop-image-upload",
                data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},
                success: function(data){
                    console.log(data);
                    $modal.modal('hide');
                    alert("Crop image successfully uploaded");
                }
              });
         }
    });
})
</script>
```
# Step 8 – Start Development Server
Execute the following command to start development server for your crop image before upload in laravel:
```php
php artisan serve
```
Then open your browser and fire the following url into your browser:
```php
http://127.0.0.1:8000/crop-image-upload
```
# Conclusion
crop image before upload in laravel 9 app; In this tutorial, i have completely guided you on how to crop image before upload to server in laravel 9 app using cropper js.