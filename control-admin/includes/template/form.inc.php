<div class=container>
    <header class='welcome'>
        <h2 class=" text-center"> WELCOME MR DO ENTER USERNAME AND PASSWORD</h2>
        <p class='text-center ' style='margin-bottom:-10px'> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ratione molestias recusandae rem animi unde ullam repellendus perspiciatis cum ad molestiae magni quo est, reiciendis dicta suscipit ut expedita saepe in?</p>
    </header>
</div>

<div class='container'>
    <div class='row'>

        <div class='col-md-5 col-sm-12 form-cont'>
            <form method = 'POST'>
                <h2 class="h1"> Admin Login </h2>
                <div class="form-group">
                    <label for="exampleInputEmail1"> Username </label>
                    <div class='input-con'>
                    <div class = 'i1'> <i class="fas fa-user fa-fw"></i></div>
                        <input type="text" value = '<?php if(!empty($error) || $checkData == true){echo $_POST['username'];} elseif(isset($_COOKIE['cookie-admin'])){echo $_COOKIE['cookie-admin'];}?>'  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Username" name='username' required>
                    </div>
                    <small id="emailHelp" class="form-text text-muted">We'll never share your Username with anyone else.</small>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <div class='input-con'>
                        <div class = 'i1'><i class="fas fa-lock fa-fw i"></i></div>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name='password' required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block submit" value='login'>Submit</button>
                <span class='forget'> If Forget Email OR password ? <a href = 'https://gaza-gifted-youth.000webhostapp.com/' target="_blank"> Connect Us</a> </span>
            </form>

        </div>
        <div class='col-md-7 col-sm-12 img-control'>

            <figure class='images'>

                <img src='layout/images/undraw_Login_v483.png' alt='No Internet' class='img-fluid' />

            </figure>

        </div>
    </div>
</div>