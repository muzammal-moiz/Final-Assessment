<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Document</title>
</head>
<style>
    .download-button{
        margin-top: 15px;
    }
</style>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="textInput" class="heading"> Enter Text</label>
                    <textarea class="form-control" id="textInput" rows="5"></textarea>
                </div>
                <button class="btn btn-primary" onclick="generateQR()">Generate QR Code</button>
            </div>
            <div class="col-md-6">
                <label for="textInput" class="heading">QR Code</label>
                <div id="qrCode" class=mt-4></div>
                <button class="btn btn-success download-button" id="downloadBtn" style="display:none;">Download QR
                    code</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        
      function generateQR() {
        var text = $('#textInput').val().trim();

        if (text === '') {
            Swal.fire({
                icon: 'info',
                title: 'Oops...',
                text: 'Please enter something.'
            });
            return;
        }

        var formattedText = text.replace(/\n/g, '\x0d');

        var csrfToken = '{{ csrf_token() }}';

        $.ajax({
            type: 'POST',
            url: '{{ route('generate.qr') }}',
            data: {
                text: formattedText,
                _token: csrfToken
            },
            success: function(response) {
                Swal.fire({
                icon: 'success',

                text: 'Qr Code generate successfully'
            });
                $('#qrCode').html(response);
                $('#downloadBtn').show();
                $('#downloadBtn').click(function() {
                    downloadQR(response);
                });
            },
            error: function(xhr, status, error) {
                alert('Error generating QR code: ' + error);
            }
        });
    }
        function downloadQR(imageData) {
        var link = document.createElement('a');
        link.download = 'qrcode.png';
        link.href = imageData;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    </script>
</body>

</html>
