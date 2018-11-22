
<nav id="nav-main" class="navbar navbar-expand-xl navbar-dark sticky-top">
    <div class="container-fluid">
        <div id="logo-main" class="navbar-header">
            <a href="/" class="navbar-brand">
                <img class="img-fluid" src="/images/logo-greenbg-clipped2.jpg" alt="логотип сайта">
            </a>
        </div>
        <button id="btn-navbar" class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mt-4 mt-xl-0" id="navbarSupportedContent">
            <div id="header-center" class="m-auto">
                <div class="navbar-nav-img">
                    <img class="img-fluid" src="/images/header-advertizing.png" alt="advertizing picture 1">
                </div>
                <ul id="navbar" class="navbar-nav">
                    <li class="nav-item <?=$navItem[0]?> mx-2">
                        <a href="/" class="nav-link"><?=ucfirst($config['pages'][0]['name'])?></a>
                    </li>
                    <li class="nav-item <?=$navItem[1]?> mx-2">
                        <a href="/pages/contacts.php" class="nav-link"><?=ucfirst($config['pages'][1]['name'])?></a>
                    </li>
                    <li class="nav-item <?=$navItem[2]?> mx-2">
                        <a href="/pages/authorization.php" class="nav-link"><?=ucfirst($config['pages'][2]['name'])?></a>
                    </li>
                </ul>
            </div>
            <form class="form-inline ml-xl-4 mt-xl-0" action="">
                <input type="text" id="search-field" class="form-control mr-4 my-2"
                       placeholder="Search" aria-label="Search">
                <button type="submit" id="search" class="btn btn-success my-2 my-xl-0">Search</button>
                <div class="w-100"></div>
                <input type="text" id="subscr-email" class="form-control mr-4 my-2"
                       placeholder="Email" aria-label="Email">
                <button type="button" id="subscribe" class="btn btn-success my-2 my-xl-0">to subscribe</button>
            </form>
        </div>
    </div>
</nav>


