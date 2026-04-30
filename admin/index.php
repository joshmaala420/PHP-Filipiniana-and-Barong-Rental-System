<style>
    * {
       padding: 0;
       margin: 0; 
    }
    .login-container{
        height: 100%;
        background-color: #333;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .login-form{
        height: 550px;
        width: 700px;
        background-color: #f2f2f2;
        border-radius: 10px;
        position: relative;
    }
    .head-title{
        height: 160px;
        width: 100%;
        background-color: blue;
        border-radius: 10px 10px 0 0;
        background-color: #21a5da;
        display: flex;
        justify-content: center;
        align-items: center;
        padding-bottom: 50px;
    }
    .head-title h2{
        font-size: 32px;
        color: white;
    }
    .input-fields{
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        margin-top: 50px;
    }
    .input-fields input{
        height: 50px;
        width: 500px;
        font-size: 20px;
        border-radius: 10px;
        padding: 15px;
    }
    .button-container{
        height: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .login-btn{
        position: absolute;
        bottom: 20px;
        padding: 10px;
        width: 300px;
        background-color: #2d5261;
        color: white;
        font-size: 20px;
    }
    .login-btn:hover{
        background-color: #70a3b8;
    }


</style>


<div class="login-container">
    <div class="login-form">
        <div class="head-title">
        <h2>Welcome Admin</h2>
        </div>
        <form action="login.php" method="POST">
            <div class="input-fields">
                <label for="">Username: </label>
                <input type="text" name="username">
            </div>
            <div class="input-fields">
                <label for="">Password: </label>
                <input type="password" name="password">
            </div>
            <div class="button-container">
                <button class="login-btn" name="login-btn">Login</button>
            </div>
        </form>
    </div>
</div>