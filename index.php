<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get users from G-sute</title>
    <style>
        .container {
            max-width: 800px;
            margin: auto;
            height: 90vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .heading {
            display: block;
            width: 100%;
            text-align: center;
            font-size: 3rem;
        }
        .sub-heading {
            display: block;
            width: 100%;
            text-align: center;
            font-size: 1.5rem;
        }
        #code {
            background-color: #1e1e1e;
            border-radius: 10px;
            padding: 20px;
            color: #d7ba5e;
            max-width: 500px;
            word-break: break-all;
        }
        #copy-btn {
            background-color: #4d94ff;
            padding: 1rem;
            border-radius: 5px;
            outline: none;
            border-color: #4d94ff;
            cursor: pointer;
            margin: 2rem;
            text-transform: uppercase;
            font-size: 1rem;
            font-weight: bold;
        }
        .input {
            position: absolute;
            left: -55555px;
        }
    </style>
</head>
<body>
<?php
if(isset($_GET['code'])) { ?>
<?php
$code = $_GET['code'];
?>
    <div class="container">
        <h1 class="heading">Get users from G-sute</h1>
        <h3 class="sub-heading">Copy below code, return to your terminal, and past it.</h3>

        <input
         type="text" 
         id="code-value" 
         class="input" 
         value="<?php echo $code; ?>"
        />

        <code id="code"><?php echo $code; ?></code>
        <button id="copy-btn" onclick="copyToClipboard()">Copy to clipboard</button>
    </div>
<?php }
else { ?>
        <div class="container">
            <h1 class="heading">Get users from G-sute</h1>
            <h3 class="sub-heading">It looks like you visit this page directly, you supposed to view this page by redirecting upon access to your G-suite account. Please return to your terminal</h3>
        </div>
<?php } ?>



    <script>
        function copyToClipboard() {
            /* Get the text field */
            var copyText = document.getElementById("code-value");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /*For mobile devices*/

            /* Copy the text inside the text field */
            document.execCommand("copy");

            document.getElementById("copy-btn").innerHTML = "Copied!"
        }
    </script>
</body>
</html>