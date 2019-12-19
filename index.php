<?php
if(!empty($_FILES['uploaded_file'])) {
    $path = 'uploads/img/';
    $path = $path . basename( $_FILES['uploaded_file']['name']);
    $allowed = array('image/jpg', 'image/jpeg', 'image/png');

    //Check uploaded file type is in the above array (therefore valid)  
    if(in_array($_FILES['uploaded_file']['type'], $allowed)){

        if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
            $notification = '
                <strong style="position: absolute; top: -7rem;color: cadetblue; font-weight: 900; border: dashed 1px;padding: 1rem 10.6rem;text-align: center;">
                    <i class="hide far fa-check-circle"></i> 
                    The file ' . basename($_FILES['uploaded_file']['name']) . ' has been uploaded successfully</strong>';
        } else {
            $error = 'There was an error uploading the file. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://bootswatch.com/4/lux/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css"">
    <link rel="stylesheet" href="./css/style.css">
  
    <title>File upload</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <span class="navbar-brand">            
            <span style="font-size:.5rem;"><a href="/">File Uploader</a></span>
        </span>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 left-col">
                <div class="instructions-container">
                    <ul class="list-group">
                        <li class="list-item active"><span class="number">1</span>Choose a photo from your computer</li>
                        <li class="list-item"><span class="number">2</span>Crop photo by resizing the corner adjusters, then save cropped selection</li>
                        <li class="list-item"><span class="number">3</span>Upload Another Photo</li>
                        <li class="list-item"><span class="number">4</span>Reorder photos if desired</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10 col-lg-6 col-xl-7 m-auto">
                <div class="form-group">
                    <form enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']; ?>"" method="post">
                    <div class="row">
                        <div class="col">
                            <?php echo $notification; ?>
                        </div>
                    </div>
                        <h5>Choose a Photo</h5>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="validatedCustomFile" name="uploaded_file" required>
                            <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>

                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                            <div class="row">
                                <div class="col-sm-6 col-md-7 col-lg-12">
                                    <div class="mt-5">                                                                                                                
                                        <div class="uploaded-files">
                                        <h5>Uploaded Files</h5>
                                            <div class="row">
                                                  <!--rightbox-->
                                                  <?php 
                                                            echo scanDirectoryImages("uploads/img");

                                                            function scanDirectoryImages($directory, array $exts = array('jpeg', 'jpg', 'gif', 'png'))
                                                                {
                                                                if (substr($directory, -1) == '/') {
                                                                    $directory = substr($directory, 0, -1);
                                                                }
                                                                $html = '';
                                                                if (
                                                                    is_readable($directory)
                                                                    && (file_exists($directory) || is_dir($directory))
                                                                ) {
                                                                    $directoryList = opendir($directory);
                                                                    while($file = readdir($directoryList)) {
                                                                        if ($file != '.' && $file != '..') {
                                                                            $path = $directory . '/' . $file;
                                                                            if (is_readable($path)) {
                                                                                if (is_dir($path)) {
                                                                                    return scanDirectoryImages($path, $exts);
                                                                                }
                                                                                if (
                                                                                    is_file($path)
                                                                                    && in_array(end(explode('.', end(explode('/', $path)))),   $exts)
                                                                                ) {
                                                                                    $html .= '
                                                                                    <a href="' . $path . '">
                                                                                    <i class="hide" style="position: absolute;right: .4rem;top:.4rem;font-size: .7rem;" class="fas fa-trash" onClick="handleDeletePhoto(event);"></i>
                                                                                    <img src="' . $path
                                                                                        . '" style="max-height:100px;max-width:100px" /></a>';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    closedir($directoryList);
                                                                }
                                                                echo $html;
                                                            }
                                                        ?>
                                                        
                                                    <div class="box-2 img-result hide">
                                                        <!-- result of crop -->                                                        
                                                        <img class="cropped" src="" alt="">
                                                        <a href="" class="btn download hide">Download</a>
                                                    </div>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- leftbox -->
                    <div class="box-2 over">
                        <div class="result hide"></div>
                         <!-- input file -->
                        <div class="box hide">
                            <div class="options hide">
                                <label> Width</label>
                                <input type="number" class="img-w" value="300" min="100" max="1200" />
                            </div>
                            <!-- save btn -->
                            <!-- <button type="submit" value="Upload" class="btn save hide">Save</button> -->
                            <input type="submit" value="Save & Upload" class="btn save hide" />
                            <!-- download btn -->
                        </div>    
                        </div>           
                </form>
            </div>
            <div class="gallery" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="gallery__bg"></div>
            </div>

        </div>

</body>
<script src="https://kit.fontawesome.com/42562b750b.js" crossorigin="anonymous" async></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js"></script>
<script src="./js/main.js"></script>
<script type="text/javascript">
    function handleDeletePhoto(event) {
        console.log("Clicked");
        event.preventDefault();
    }
</script>
</html>