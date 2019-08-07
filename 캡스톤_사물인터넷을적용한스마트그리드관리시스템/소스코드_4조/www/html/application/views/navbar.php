<!-- Header -->
    <header>
        <div class="sticky-nav">
            <a id="mobile-nav" class="menu-nav"></a>

            <div id="logo">
                <a id="goUp" href="#home-slider" title="Brushed | Responsive One Page Template"></a>
            </div>

            <nav id="menu">
                <ul id="menu-nav">
                    <li><a href="/index.php/home" id="main" class="externalMain">Home</a></li>
                    <li><a href="/index.php/home/switches" id="smarthome" class="externalSwitch">Device</a></li>
                    <li><a href="/index.php/home/charges" id="charges" class="externalCharges">Status</a></li>
					<li><a href="/index.php/home/external">Analysis</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <!-- End Header -->
<script type='text/javascript'>
	var uri = '/index.php/' + '<?=$this->uri->uri_string()?>'
	obj = document.getElementById('menu-nav').children;

	for(var i = 0; i < obj.length; i++){
		if (obj[i].children[0].getAttribute('href') == uri){
			obj[i].classList.add('current');	
		}
	}


</script>
