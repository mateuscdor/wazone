@extends('layouts.header_min')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <!-- <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div> -->
        <div class="content-wrapper col-6 container-xxl p-0">
            <div class="content-header row">
                <div class="text-center">
                    <h1 class="mt-5">License Activator</h1>
                </div>
                <div class="card text-center">
                    <div class="card-body">
                        <?php
                        if(!empty($_GET['license'])){
                          $license = strip_tags(trim($_GET["license"]));
                          $response = \Helper::activate($license);
                          if(empty($response['success'])){ 
                            $msg = 'Activation Failed! Invalid License Key!<br><br>Please login to <a href="https://visimisi.net/my-account" target="_blank" rel="noopener noreferrer">MY ACCOUNT</a><br><br>Click on LICENSE KEYS.<br>If activation limit reached, click Deactivate button,<br>then Activate on this server!'; ?>
                            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                              <div class="notification is-danger is-light"><?php echo ucfirst($msg); ?></div>
                              <div class="col-12">
                                  <input type="text" name="license" class="form-control" placeholder="Enter your License Key" required />
                              </div>
                              <div class="col-12 text-center mt-2 pt-50">
                                  <button type="submit" class="btn btn-primary me-1">Activate</button>
                              </div>
                            </form><?php
                          }else{
                            $msg = 'Activation Success!<br><br>Please wait, getting things ready...<br><br><a href="{{ $this->redirectTo = url()->previous(); }}">' . __('Click HERE') . '</a> if it is not redirecting after 5 seconds'; ?>
                            <div class="notification is-success is-light"><?php echo ucfirst($msg); ?></div>
                            <!-- <a href="{{ url('device-list') }}" class="btn btn-primary">I understand</a> -->
                            <script>setTimeout(function () {window.location.href = "{{ url('device-list') }}";}, 4000);</script>
                    <?php }
                        }else{ ?>
                          <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                          <div class="col-12">
                                  <input type="text" name="license" class="form-control" placeholder="Enter your License Key" required />
                              </div>
                              <div class="col-12 text-center mt-2 pt-50">
                                  <button type="submit" class="btn btn-primary me-1">Activate</button>
                              </div>
                          </form><?php 
                        } ?>
                        </div>
                </div>
            </div>
        </div>
    </div>

@extends('layouts.footer')
