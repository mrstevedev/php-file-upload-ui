console.log('//---SmugMug Image Uploader');

// Get File Input
let result = document.querySelector('.result'),
 box = document.querySelector('.box');
 file = document.querySelector('.custom-file-input'),
 label = document.querySelector('.custom-file-label'),
 img_result = document.querySelector('.img-result'),
 img_w = document.querySelector('.img-w'),
 img_h = document.querySelector('.img-h'),
 listGroup = document.querySelectorAll('.list-group li'),
 options = document.querySelector('.options'),
 save = document.querySelector('.save'),
 cropped = document.querySelector('.cropped'),
 dwn = document.querySelector('.download'),
 upload = document.querySelector('#file-input'),
 cropper = "";

file.addEventListener('change', event => {
    label.innerHTML = event.target.value.split('\\').pop();
    console.log(event.target.files);
    if(event.target.files.length) {
        listGroup[0].classList.remove('active');
        listGroup[1].classList.add('active');
        // start file reader
        const reader = new FileReader();
        reader.onload = event => {
            if(event.target.result){
                // create new image 
                let img = document.createElement('img');
                img.id = 'image';
                img.src = event.target.result;
                // clean result before 
                result.innerHTML = '';
                // append new image 
                result.appendChild(img);
                // Show save button and options
                save.classList.remove('hide');
                result.classList.remove('hide');
                box.classList.remove('hide');
                options.classList.remove('hide');
                // init cropper 
                cropper = new Cropper(img);
                console.log(cropper);
            }
        }
        reader.readAsDataURL(event.target.files[0]);
    }
});

// save on click
save.addEventListener('click', (event) => {
    // event.preventDefault();
    // get the results to data uri
    let imgSrc = cropper.getCroppedCanvas({
        width: img_w.value // input value
    }).toDataURL();
    // Remove hide class of img
    // cropped.classList.remove('hide');
    // img_result.classList.remove('hide');
    // // show image cropped
    // cropped.src = imgSrc;
    // dwn.classList.remove('hide');
    // dwn.download = 'imagename.png';
    // dwn.setAttribute('href', imgSrc);

    // close result
    box.classList.toggle('hide');
    result.classList.toggle('hide');

    // listGroup[1].classList.remove('active');
    // listGroup[2].classList.add('active');
});


