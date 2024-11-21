@if (session()->has('success'))
    <div id="success-message" style="display: none;">
        <div class="alert alert-success d-flex align-items-center" role="alert" style="max-width: 350px;">
            <p>{{ session('success') }}</p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const successMessage = document.getElementById('success-message');
            successMessage.style.display = 'block';
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000);
        });
    </script>

    <style>
        #success-message {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }

        .alert {
            margin: 0;
            border-radius: 5px;
            padding: 10px;
        }
    </style>
@endif
