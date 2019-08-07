<!DOCTYPE html>
<!-- Our Shortcodes Section -->
<div id="shortcodes" class="page">
    <div class="container">

        <!-- Title Page -->
        <div class="row">
            <div class="span12">
                <div class="title-page">
                    <h2 class="title">SmartHome</h2>
                    <h3 class="title-description">Smart Home based with Smart Grid</h3>
                </div>
            </div>
        </div>
        <!-- End Title Page -->

        <!-- login form-->
        <div class="wrapper fadeInDown">
          <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Login Form -->
            <form action="/index.php/auth/authentication" method="post">
              <input type="text" id="id" class="fadeIn second" name="id" placeholder="ID">
              <input type="password" id="pw" class="fadeIn third" name="pw" placeholder="Password">
<p></p>		
              <input id="temp" name="temp" style="visibility:hidden;">
              <input type="submit" id="submit" class="fadeIn fourth" value="Log In">
            </form>


          </div>
        </div>
    </div>
</div>

