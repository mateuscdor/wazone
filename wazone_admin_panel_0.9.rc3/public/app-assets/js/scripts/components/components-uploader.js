Dropzone.autoDiscover = false;

$(function () {
  var myDropzone = $('#module_uploader').dropzone({
    paramName: 'file', // The name that will be used to transfer the file
    maxFilesize: 50, // MB
    maxFiles: 1,
    dictDefaultMessage: 'Drag & Drop <strong>WZ-ModuleName.zip</strong> file',
    autoProcessQueue: true,
    acceptedFiles: '.zip',
    init: function () {
      this.on('addedfile', function (file) {
        if (this.fileTracker) {
          this.removeFile(this.fileTracker);
        }
        this.fileTracker = file;
      });

      var dropzone = this;

      //when file added or dropped, process the file for auto-upload
      dropzone.on('addedfile', function (file) {
        let filename = file.name;
        if (filename.toLowerCase().startsWith('wz-')) {
          let timerInterval;
          Swal.fire({
            title: 'Module Uploaded Successfully!',
            html: 'Setting The Environment Up...',
            timer: 1000,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading();
              // const b = Swal.getHtmlContainer().querySelector('b');
              // timerInterval = setInterval(() => {
              //   b.textContent = Swal.getTimerLeft();
              // }, 1000);
            },
            willClose: () => {
              clearInterval(timerInterval);
            },
          }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Module was Installed Successfully',
                text: 'Redirecting...',
                showConfirmButton: false,
                timer: 1500,
              });
              setTimeout(function () {
                window.location.reload();
              }, 1600);
            }
          });
          setTimeout(function () {
            dropzone.processQueue();
          }, 2200);
        }
      });
    },
    accept: function (file, done) {
      let filename = file.name;
      if (filename.toLowerCase().startsWith('wz-')) {
        done();
      } else {
        //else remove the file and show error message
        this.removeFile(file);
        $(function () {
          Swal.fire('Oops Wrong File Uploaded', 'Upload only the WZ-ModuleName.zip File', 'error');
        });
        done();
      }
    },
    success: function (file, response) {
      console.log(`SUCCESS: ${file.name} successfully uploaded.`);
    },
    error: function (file, response) {
      return false;
    },
  });

  $('.enDisBtn')
    .dblclick(function (event) {
      $(this).addClass('pointer-none');
      window.location = this.href;
      return false;
    })
    .click(function (event) {
      return false;
    });
});
