        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 h-100">
                <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end">
                        <h6 class="text-white font-weight-bold piccolo">PNL Studio</h6>
                        <h1 class="text-white font-weight-bold grande"><?php echo $nomepagina?></h1>
                        <hr class="divider" />
                    </div>
                    <div class="col-lg-8 align-self-baseline">
                        <!--<p class="text-white-75 mb-5">Scopri chi siamo</p>-->
                        <a class="btn btn-primary btn-xl" href="login.php#login_section"><?php echo(isset($login_email) ? "Welcome " . $login_username : "Sign in/Sign up")  ?></a>
                    </div>
                </div>
            </div>
        </header>